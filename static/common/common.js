/*
 * Author : Lensic
 * Blog   : http://lensic.sinaapp.com/
 */

/*
 * 分页位置
 * 
 * location : 默认为居左对齐，center = 居中对齐，right = 居右对齐
 */
function page_location(location)
{
	if(location == 'center')
	{
		$('.page_container').width($('.page_style').width());
	} else if(location == 'right') {
		$('.page_style').css('float', 'right');
	}
}

$(function (){
	/*
	 * 清除分页最后一个链接的 margin-right
	 */
	$('.page_style a').eq($('.page_style a').length - 1).css('margin-right', 0);
});

/*
 * 更换验证码
 * 
 * obj : 对象容器 id 值
 */
function change_captcha(obj)
{
	$.post('http://' + window.location.host + '/common/captcha', {}, function (msg){
		$('#' + obj).html(msg);
	});
	return false;
}