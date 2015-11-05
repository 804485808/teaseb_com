<?php
class MY_Image_lib extends CI_Image_lib{

    function display_resize()
    {
        // If resizing the x/y axis must be zero
        $this->x_axis = 0;
        $this->y_axis = 0;

        //  Create the image handle
        if ( ! ($src_img = $this->image_create_gd()))
        {
            return FALSE;
        }

        if ($this->image_library == 'gd2' AND function_exists('imagecreatetruecolor'))
        {
            $create	= 'imagecreatetruecolor';
            $copy	= 'imagecopyresampled';
        }
        else
        {
            $create	= 'imagecreate';
            $copy	= 'imagecopyresized';
        }
        $dst_img = $create($this->width, $this->height);

        if ($this->image_type == 3) // png we can actually preserve transparency
        {
            imagealphablending($dst_img, FALSE);
            imagesavealpha($dst_img, TRUE);
        }


//        $source_image = imagecreatefromjpeg('http://img.motors-biz.com/file/upload/sell/20140709/z4_series_gear_motors_for_cranes.jpg');
//        $source_image = imagecreatefromjpeg($img);
//        $source_info = getimagesize($img);
//        $source_width = $source_info[0];
//        $source_height = $source_info[1];
//        $target_image = imagecreatetruecolor(400, 400);
//        imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, 400, 400, $source_width, $source_height);
//        return $target_image;


        $copy($dst_img, $src_img, 0, 0, $this->x_axis, $this->y_axis, $this->width, $this->height, $this->orig_width, $this->orig_height);

        //  Show the image
        if ($this->dynamic_output == TRUE)
        {
            return  $dst_img;
        }
        else
        {
            // Or save it
            //if ( ! $this->image_save_gd($dst_img))
            //{
            //return FALSE;
            //}
        }

    }

    function display_watermark($src_img)
    {
        if ( ! function_exists('imagecolortransparent'))
        {
            $this->set_error('imglib_gd_required');
            return FALSE;
        }

        //  Fetch source image properties
        $this->get_image_properties();

        //  Fetch watermark image properties
        $props			= $this->get_image_properties($this->wm_overlay_path, TRUE);
        $wm_img_type	= $props['image_type'];
        $wm_width		= $props['width'];
        $wm_height		= $props['height'];

        //  Create two image resources
        $wm_img  = $this->image_create_gd($this->wm_overlay_path, $wm_img_type);
        //$src_img = $this->image_create_gd($this->full_src_path);

        $this->orig_width = imagesx($src_img);
        $this->orig_height = imagesy($src_img);

        // Reverse the offset if necessary
        // When the image is positioned at the bottom
        // we don't want the vertical offset to push it
        // further down.  We want the reverse, so we'll
        // invert the offset.  Same with the horizontal
        // offset when the image is at the right

        $this->wm_vrt_alignment = strtoupper(substr($this->wm_vrt_alignment, 0, 1));
        $this->wm_hor_alignment = strtoupper(substr($this->wm_hor_alignment, 0, 1));

        if ($this->wm_vrt_alignment == 'B')
            $this->wm_vrt_offset = $this->wm_vrt_offset * -1;

        if ($this->wm_hor_alignment == 'R')
            $this->wm_hor_offset = $this->wm_hor_offset * -1;

        //  Set the base x and y axis values
        $x_axis = $this->wm_hor_offset + $this->wm_padding;
        $y_axis = $this->wm_vrt_offset + $this->wm_padding;

        //  Set the vertical position
        switch ($this->wm_vrt_alignment)
        {
            case 'T':
                break;
            case 'M':	$y_axis += ($this->orig_height / 2) - ($wm_height / 2);
                break;
            case 'B':	$y_axis += $this->orig_height - $wm_height;
                break;
        }

        //  Set the horizontal position
        switch ($this->wm_hor_alignment)
        {
            case 'L':
                break;
            case 'C':	$x_axis += ($this->orig_width / 2) - ($wm_width / 2);
                break;
            case 'R':	$x_axis += $this->orig_width - $wm_width;
                break;
        }

        //  Build the finalized image
        if ($wm_img_type == 3 AND function_exists('imagealphablending'))
        {
            @imagealphablending($src_img, TRUE);
        }

        // Set RGB values for text and shadow
        $rgba = imagecolorat($wm_img, $this->wm_x_transp, $this->wm_y_transp);
        $alpha = ($rgba & 0x7F000000) >> 24;

        // make a best guess as to whether we're dealing with an image with alpha transparency or no/binary transparency
        if ($alpha > 0)
        {
            // copy the image directly, the image's alpha transparency being the sole determinant of blending
            imagecopy($src_img, $wm_img, $x_axis, $y_axis, 0, 0, $wm_width, $wm_height);
        }
        else
        {
            // set our RGB value from above to be transparent and merge the images with the specified opacity
            imagecolortransparent($wm_img, imagecolorat($wm_img, $this->wm_x_transp, $this->wm_y_transp));
            imagecopymerge($src_img, $wm_img, $x_axis, $y_axis, 0, 0, $wm_width, $wm_height, $this->wm_opacity);
        }

        //  Output the image
        if ($this->dynamic_output == TRUE)
        {
            return $src_img;
        }
        else
        {
            //if ( ! $this->image_save_gd($src_img))
            //{
            //return FALSE;
            //}
        }

    }

    function display_textmark($src_img)
    {
        //if ( ! ($src_img = $this->image_create_gd()))
        //{
        //return FALSE;
        //}


        if ($this->wm_use_truetype == TRUE AND ! file_exists($this->wm_font_path))
        {
            $this->set_error('imglib_missing_font');
            return FALSE;
        }

        //  Fetch source image properties
        $this->get_image_properties();

        $this->orig_width = imagesx($src_img);
        $this->orig_height = imagesy($src_img);

        // Set RGB values for text and shadow
        $this->wm_font_color	= str_replace('#', '', $this->wm_font_color);
        $this->wm_shadow_color	= str_replace('#', '', $this->wm_shadow_color);

        $R1 = hexdec(substr($this->wm_font_color, 0, 2));
        $G1 = hexdec(substr($this->wm_font_color, 2, 2));
        $B1 = hexdec(substr($this->wm_font_color, 4, 2));

        $R2 = hexdec(substr($this->wm_shadow_color, 0, 2));
        $G2 = hexdec(substr($this->wm_shadow_color, 2, 2));
        $B2 = hexdec(substr($this->wm_shadow_color, 4, 2));

        $txt_color	= imagecolorclosest($src_img, $R1, $G1, $B1);
        $drp_color	= imagecolorclosest($src_img, $R2, $G2, $B2);

        // Reverse the vertical offset
        // When the image is positioned at the bottom
        // we don't want the vertical offset to push it
        // further down.  We want the reverse, so we'll
        // invert the offset.  Note: The horizontal
        // offset flips itself automatically

        if ($this->wm_vrt_alignment == 'B')
            $this->wm_vrt_offset = $this->wm_vrt_offset * -1;

        if ($this->wm_hor_alignment == 'R')
            $this->wm_hor_offset = $this->wm_hor_offset * -1;

        // Set font width and height
        // These are calculated differently depending on
        // whether we are using the true type font or not
        if ($this->wm_use_truetype == TRUE)
        {
            if ($this->wm_font_size == '')
                $this->wm_font_size = '17';

            $fontwidth  = $this->wm_font_size-($this->wm_font_size/4);
            $fontheight = $this->wm_font_size;
            $this->wm_vrt_offset += $this->wm_font_size;
        }
        else
        {
            $fontwidth  = imagefontwidth($this->wm_font_size);
            $fontheight = imagefontheight($this->wm_font_size);
        }

        // Set base X and Y axis values
        $x_axis = $this->wm_hor_offset + $this->wm_padding;
        $y_axis = $this->wm_vrt_offset + $this->wm_padding;

        // Set verticle alignment
        if ($this->wm_use_drop_shadow == FALSE)
            $this->wm_shadow_distance = 0;

        $this->wm_vrt_alignment = strtoupper(substr($this->wm_vrt_alignment, 0, 1));
        $this->wm_hor_alignment = strtoupper(substr($this->wm_hor_alignment, 0, 1));

        switch ($this->wm_vrt_alignment)
        {
            case	 "T" :
                break;
            case "M":	$y_axis += ($this->orig_height/2)+($fontheight/2);
                break;
            case "B":	$y_axis += ($this->orig_height - $fontheight - $this->wm_shadow_distance - ($fontheight/2));
                break;
        }

        $x_shad = $x_axis + $this->wm_shadow_distance;
        $y_shad = $y_axis + $this->wm_shadow_distance;

        // Set horizontal alignment
        switch ($this->wm_hor_alignment)
        {
            case "L":
                break;
            case "R":
                if ($this->wm_use_drop_shadow)
                    $x_shad += ($this->orig_width - $fontwidth*strlen($this->wm_text));
                $x_axis += ($this->orig_width - $fontwidth*strlen($this->wm_text));
                break;
            case "C":
                if ($this->wm_use_drop_shadow)
                    $x_shad += floor(($this->orig_width - $fontwidth*strlen($this->wm_text))/2);
                $x_axis += floor(($this->orig_width  -$fontwidth*strlen($this->wm_text))/2);
                break;
        }

        //  Add the text to the source image
        if ($this->wm_use_truetype)
        {
            if ($this->wm_use_drop_shadow)
                imagettftext($src_img, $this->wm_font_size, 0, $x_shad, $y_shad, $drp_color, $this->wm_font_path, $this->wm_text);
            imagettftext($src_img, $this->wm_font_size, 0, $x_axis, $y_axis, $txt_color, $this->wm_font_path, $this->wm_text);
        }
        else
        {
            if ($this->wm_use_drop_shadow)
                imagestring($src_img, $this->wm_font_size, $x_shad, $y_shad, $this->wm_text, $drp_color);
            imagestring($src_img, $this->wm_font_size, $x_axis, $y_axis, $this->wm_text, $txt_color);
        }

        //  Output the final image
        if ($this->dynamic_output == TRUE)
        {
            return $src_img;
        }
        else
        {
            //$this->image_save_gd($src_img);
        }
    }

    function image_display_gd($resource)
    {
        header("Content-Type: {$this->mime_type}");
        $expirestime = 60*60*24*30;

        $etag = $this->source_folder.$this->source_image;
        $etag = md5($etag);


        /*
        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
                //header("HTTP/1.0 304 Not Modified");
                $browserCachedCopyTimestamp = strtotime(preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE']));
                if($browserCachedCopyTimestamp + $expirestime >= time()) {
                        header("HTTP/1.0 304 Not Modified");
                        exit;
                }else{
                        header("Cache-Control:max-age={$expirestime}");
                        header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
                        header('Expires: '.gmdate('D, d M Y H:i:s', time()+$expirestime).' GMT');
                }
        }else{
                header("Cache-Control:max-age={$expirestime}");
                header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
                header('Expires: '.gmdate('D, d M Y H:i:s', time()+$expirestime).' GMT');
        }
        */
        if((isset($_SERVER['HTTP_IF_NONE_MATCH'])) && (stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == $etag)) {
            header("HTTP/1.1 304 Not Modified", TRUE, 304);
            exit();
        }
        header("ETag: ".$etag);
        header("Accept-Ranges: bytes");
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
        header('Expires: '.gmdate('D, d M Y H:i:s', time()+$expirestime).' GMT');

        ob_start();
        switch ($this->image_type)
        {
            case 1          :       imagegif($resource);
                break;
            case 2          :       imagejpeg($resource, NULL, $this->quality);
                break;
            case 3          :       imagepng($resource);
                break;
            default         :       echo 'Unable to display the image';
            break;
        }
        $size = ob_get_length();
        header("Content-Length: ".$size);
        ob_end_flush();


    }

}