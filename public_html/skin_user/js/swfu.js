var SWFUpload;
if (typeof(SWFUpload) === "function") {
    SWFUpload.prototype.initSettings = function (oldInitSettings) {
        return function () {
            if (typeof(oldInitSettings) === "function") {
                oldInitSettings.call(this);
            }
            this.refreshCookies(false);
        };
    }(SWFUpload.prototype.initSettings);

    // refreshes the post_params and updates SWFUpload.  The sendToFlash parameters is optional and defaults to True
    SWFUpload.prototype.refreshCookies = function (sendToFlash) {
        if (sendToFlash === undefined) {
            sendToFlash = true;
        }
        sendToFlash = !!sendToFlash;

        // Get the post_params object
        var postParams = this.settings.post_params;

        // Get the cookies
        var i, cookieArray = document.cookie.split(';'), caLength = cookieArray.length, c, eqIndex, name, value;
        for (i = 0; i < caLength; i++) {
            c = cookieArray[i];

            // Left Trim spaces
            while (c.charAt(0) === " ") {
                c = c.substring(1, c.length);
            }
            eqIndex = c.indexOf("=");
            if (eqIndex > 0) {
                name = c.substring(0, eqIndex);
                value = c.substring(eqIndex + 1);
                postParams[name] = value;
            }
        }

        if (sendToFlash) {
            this.setPostParams(postParams);
        }
    };

}

/*
Queue Plug-in

Features:
    *Adds a cancelQueue() method for cancelling the entire queue.
    *All queued files are uploaded when startUpload() is called.
    *If false is returned from uploadComplete then the queue upload is stopped.
     If false is not returned (strict comparison) then the queue upload is continued.
    *Adds a QueueComplete event that is fired when all the queued files have finished uploading.
     Set the event handler with the queue_complete_handler setting.

*/

var SWFUpload;
if (typeof(SWFUpload) === "function") {
	SWFUpload.queue = {};

	SWFUpload.prototype.initSettings = (function (oldInitSettings) {
		return function () {
			if (typeof(oldInitSettings) === "function") {
				oldInitSettings.call(this);
			}

			this.queueSettings = {};

			this.queueSettings.queue_cancelled_flag = false;
			this.queueSettings.queue_upload_count = 0;

			this.queueSettings.user_upload_complete_handler = this.settings.upload_complete_handler;
			this.queueSettings.user_upload_start_handler = this.settings.upload_start_handler;
			this.settings.upload_complete_handler = SWFUpload.queue.uploadCompleteHandler;
			this.settings.upload_start_handler = SWFUpload.queue.uploadStartHandler;

			this.settings.queue_complete_handler = this.settings.queue_complete_handler || null;
		};
	})(SWFUpload.prototype.initSettings);

	SWFUpload.prototype.startUpload = function (fileID) {
		this.queueSettings.queue_cancelled_flag = false;
		this.callFlash("StartUpload", [fileID]);
	};

	SWFUpload.prototype.cancelQueue = function () {
		this.queueSettings.queue_cancelled_flag = true;
		this.stopUpload();

		var stats = this.getStats();
		while (stats.files_queued > 0) {
			this.cancelUpload();
			stats = this.getStats();
		}
	};

	SWFUpload.queue.uploadStartHandler = function (file) {
		var returnValue;
		if (typeof(this.queueSettings.user_upload_start_handler) === "function") {
			returnValue = this.queueSettings.user_upload_start_handler.call(this, file);
		}

		// To prevent upload a real "FALSE" value must be returned, otherwise default to a real "TRUE" value.
		returnValue = (returnValue === false) ? false : true;

		this.queueSettings.queue_cancelled_flag = !returnValue;

		return returnValue;
	};

	SWFUpload.queue.uploadCompleteHandler = function (file) {
		var user_upload_complete_handler = this.queueSettings.user_upload_complete_handler;
		var continueUpload;

		if (file.filestatus === SWFUpload.FILE_STATUS.COMPLETE) {
			this.queueSettings.queue_upload_count++;
		}

		if (typeof(user_upload_complete_handler) === "function") {
			continueUpload = (user_upload_complete_handler.call(this, file) === false) ? false : true;
		} else if (file.filestatus === SWFUpload.FILE_STATUS.QUEUED) {
			// If the file was stopped and re-queued don't restart the upload
			continueUpload = false;
		} else {
			continueUpload = true;
		}

		if (continueUpload) {
			var stats = this.getStats();
			if (stats.files_queued > 0 && this.queueSettings.queue_cancelled_flag === false) {
				this.startUpload();
			} else if (this.queueSettings.queue_cancelled_flag === false) {
				this.queueEvent("queue_complete_handler", [this.queueSettings.queue_upload_count]);
				this.queueSettings.queue_upload_count = 0;
			} else {
				this.queueSettings.queue_cancelled_flag = false;
				this.queueSettings.queue_upload_count = 0;
			}
		}
	};
}

function fileQueued(file) {
	try {
	} catch (ex) {
		this.debug(ex);
	}
}

function fileQueueError(file, errorCode, message) {
	try {
		if(errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
            qmsg(this, 'Allow Upload:' + message + ' image.');
			return;
		}
    	switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
            qmsg(this, file.name + " The size of the file more than  ：" + this.settings.file_size_limit);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
            qmsg(this, file.name + " is not a valid image file。");
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			qmsg(this, file.name + " System is only allowed to upload ：" + this.settings.file_types);
			break;
		default:
			qmsg(this, "File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
			document.getElementById(this.customSettings.uploaded_message).style.display='';
		}
		this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
        qmsg(this, 'Upload Start:' + file.name);
	} catch (ex) {}
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
        qmsg(this, 'Upload Progress: ' + file.name + ' ' + percent + '%');
	} catch (ex) {
		this.debug(ex);
	}
}

// 上传错误
function uploadError(file, errorCode, message) {
	try {
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			if (this.getStats().files_queued === 0) {

			}
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			break;
		default:
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

// 上传完成后
function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
	}
}

// 列队完成后
function queueComplete(numFilesUploaded) {

}

function qmsg(swfu, $str){
    document.getElementById(swfu.customSettings.uploaded_message).innerHTML = $str;
}

var swfu;
$(function(){
  var settings = {
    flash_url:              "/skin_user/js/swfupload.swf",
    upload_url:             "/index.php/uploadimg/index/sell",
    file_post_name:         'cover_upload',
    file_size_limit:        '2048 KB',
    file_types:             "*.gif;*.png;*.jpg;*.jpeg",
    file_types_description: "All Files",
    file_upload_limit:      1,
    file_queue_limit:       0,
    custom_settings: {
      uploaded_message: 'uploaded_message_panel',
      uploaded_preview: 'uploaded_preview_panel',
      uploaded_path:    'uploaded_path'
    },
    debug: false,

    // Button Settings
    button_action:            SWFUpload.BUTTON_ACTION.SELECT_FILE,
    button_window_mode:       SWFUpload.WINDOW_MODE.WINDOWS, // OPAQUE || TRANSPARENT || WINDOWS
    button_placeholder_id:    "spanButtonPlaceholder",
    button_image_url:         "/skin_user/images/upload_button.png",
    button_width:             "77",
    button_height:            "28",
    button_text:              '<span class="browse_button"><b>Browse</b></span>',
    button_text_style:        ".browse_button{color:#ffffff;text-align:center;font-size:14px;}",
    button_text_top_padding:  3,
    button_cursor:            -2,

    // The event handler functions are defined in handlers.js
    file_queued_handler:          fileQueued,
    file_queue_error_handler:     fileQueueError,
    file_dialog_complete_handler: fileDialogComplete,
    upload_start_handler:         uploadStart,
    upload_progress_handler:      uploadProgress,
    upload_error_handler:         uploadError,
    upload_success_handler:       uploadSuccess,
    upload_complete_handler:      uploadComplete,
    queue_complete_handler:       queueComplete
  };
  swfu = new SWFUpload(settings);
});