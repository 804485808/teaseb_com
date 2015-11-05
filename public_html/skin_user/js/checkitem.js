// JavaScript Document
$(document).ready(function() {
    // 全选
    $("#checkAll").click(function() {
        var flag = $("#checkAll").attr("checked");
        if (flag) {
            $("input[name='chk']").each(function() {
                $(this).attr("checked", true);
            });
        } else {
            $("input[name='chk']").each(function() {
                $(this).attr("checked", false);
            });
        }
    });
    $("#delbtn").click(function() {
        var selectItem = new Array();
        $("input[name='chk']:checked").each(function() {
            selectItem.push($(this).val());// 在数组中追加元素
        });

        if (selectItem.length == 0) {
            alert("Please select a option to delete！");
        } else {
            $.ajax({
                type : "POST",
                url : "mes_dels",
                data : 'mid=' + selectItem.join(","),
                dataType : "text",
                success : function(msg) {
                    msg = msg.replace(/\^\s*/, "mid");
                    alert(msg);
                    if (msg == "Deleted successfully! ") {
                        $("input[@name='chk']:checked").each(function() {
                            $(this).parent().parent().remove();
                        });
                    }
                }
            });
        }
    });
});