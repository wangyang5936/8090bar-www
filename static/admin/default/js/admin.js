// 后台脚本

/*
 * 获得当前时间
 */
function get_time()
{
	var date = new Date();
	$('#local_time').html(date.toLocaleString());
}
$(function() {
	if ($('#local_time').length > 0)
	{
		window.setInterval('get_time()', 1000);
	}
	$('#lc_form').submit(function() {
		if (!$('#username').val())
		{
			$.alert('请输入用户名', 'username');
			$('#username').focus();
			return false;
		}
		if (!$('#password').val())
		{
			$.alert('请输入密码', 'password');
			$('#password').focus();
			return false;
		}
	});
	$('#power_form').submit(function() {
		if (!$('#power_name').val())
		{
			$.alert('请输入权限名称', 'power_name');
			$('#power_name').focus();
			return false;
		}
	});
	$('#group_power_form').submit(function() {
		if (!$('#group_name').val())
		{
			$.alert('请输入权限组名称', 'group_name');
			$('#group_name').focus();
			return false;
		}
		if ($('input[name="power_ids[]"]:checked').length < 1)
		{
			$.alert('请选择该组具备的权限', 'group_name');
			return false;
		}
	});
	$('#user_form').submit(function() {
		if ($('#username').length > 0 && !$('#username').val())
		{
			$.alert('请输入用户名', 'username');
			$('#username').focus();
			return false;
		}
		if ($('#password').length > 0 && !$('#password').val())
		{
			$.alert('请输入密码', 'password');
			$('#password').focus();
			return false;
		}
		if (!$('#power_group_id').val())
		{
			$.alert('请选择所属权限组', 'power_group_id');
			$('#power_group_id').focus();
			return false;
		}
	});
	$('#pwd_form').submit(function() {
		if (!$('#old_password').val())
		{
			$.alert('请输入旧密码', 'old_password');
			$('#old_password').focus();
			return false;
		}
		if (!$('#password').val())
		{
			$.alert('请输入新密码', 'password');
			$('#password').focus();
			return false;
		}
		if ($('#check_password').val() != $('#password').val())
		{
			$.alert('确认新密码错误', 'check_password');
			$('#check_password').focus();
			return false;
		}
	});
});