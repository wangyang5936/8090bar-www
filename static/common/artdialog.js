/*
 * Author : Lensic
 * Blog   : http://lensic.sinaapp.com/
 */

/* 对话框组件脚本，依赖 jquery */

var art_dialog_prompt = '提示';
var art_dialog_time = 2000;
var art_dialog_okValue = '确定';
var art_dialog_cancelValue = '取消';
$.extend({
    alert: function(show_content, follow_obj, url, del_obj, reload) {
        art.dialog({
            title: art_dialog_prompt,
            content: show_content,
            follow: document.getElementById(follow_obj),
            okValue: art_dialog_okValue,
            ok: function() {
                if (url) {
                    window.location.href = url;
                }
                if (del_obj) {
                    $('#' + del_obj).fadeOut(art_dialog_time, function() {
                        $(this).remove();
                    });
                }
                if (reload) {
                    location.reload();
                }
            }
        }).lock();
    },
    delconfirm: function(show_content, url, del_obj) {
        art.dialog({
            title: art_dialog_prompt,
            content: show_content,
            fixed: true,
            focus: false,
            okValue: art_dialog_okValue,
            ok: function() {
                if (url)
                {
                    $.get(url, function(msg) {
                        if (msg == 1)
                        {
                            $.alert('删除成功', null, null, del_obj);
                        } else {
                            $.alert('删除失败或未找到记录');
                        }
                    });
                }
            },
            cancelValue: art_dialog_cancelValue,
            cancel: true
        }).shake();
        return false;
    },
    showdiv: function(show_content, url, title, form) {
        art.dialog({
            title: title,
            content: show_content,
            okValue: '提交',
            ok: function() {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $('#' + form).serialize(),
                    dataType: "json",
                    success: function(result) {
                        if (result.error > 0) {
                            $.alert(result.message);
                        } else {
                            $.alert('提交成功', null, null, null, true);
                        }
                    }
                });
            },
            cancelValue: art_dialog_cancelValue,
            cancel: true
        });
    }
});