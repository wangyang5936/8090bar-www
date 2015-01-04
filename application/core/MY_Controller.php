<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

/*
 * Author : wangyang
 */

/*
 * 扩展 Controller 类
 *
 * 设置默认编码为 utf-8
 * 设置默认时区为东八区
 * 加入站点标题全局常量 __TITLE__
 * 加入资源全局常量 __RESOURCES__
 * 加入公共样式全局常量 __COMMON_STATIC__
 * 加入上传文件全局常量 __UPLOADS__
 */

class MY_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
		header('Content-type:text/html; charset=utf-8');
		date_default_timezone_set('Asia/Shanghai');
		define('__TITLE__', $this -> config -> item('web_title'));
		define('__RESOURCES__', $this -> config -> item('base_url') . '/' . $this -> config -> item('web_resource') . '/');
		define('__COMMON_STATIC__', $this -> config -> item('base_url') . '/static/common/');
		define('__UPLOADS__', $this -> config -> item('base_url') . '/' . $this -> config -> item('web_upload') . '/');
	}

}

/*
 * 前端控制器类
 */

class M_Controller extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

}

/*
 * 后端控制器类
 */

class A_Controller extends MY_Controller {

	function __construct() {
		parent::__construct();

		// 后台登录验证处理
		$this -> load -> model('admin/m_home');
		$session = $this -> m_home -> get_session();
		if ( $this -> uri -> uri_string === 'admin/home/login' ) {
			if ( $session['admin_uid'] && $session['admin_username'] ) {
				redirect('admin/home/index');
			}
		} else {
			if ( !$session['admin_uid'] || !$session['admin_username'] ) {
				redirect('admin/home/login');
			}
		}

		// 修改视图路径
		$this -> load -> set_admin_template($this -> config -> item('web_admin_template'));
		define('__ADMIN_STATIC__', $this -> config -> item('base_url') . '/static/admin/' . $this -> config -> item('web_admin_template') . '/');

		// 加载对话框辅助函数
		$this -> load -> helper('my_artdialog');
	}

	/*
	 * 检查是否具有权限
	 *
	 * $power_name : 权限名称
	 * $return     : 返回值处理
	 */

	function check_power($page_name, $return = FALSE) {
		$check_power = $this -> m_home -> check_power($page_name);
		if ( !$check_power ) {
			if ( $return ) {
				return FALSE;
			}
			die("{$page_name}功能暂停使用或不具备访问权限");
		}
		return $page_name;
	}

}

/**
 * 脚本控制器类
 */
class S_Controller extends MY_Controller {

	protected $lock_file;
	protected $ex_time;
	public function __construct() {
		parent::__construct();
		
		$ip = $this -> input -> ip_address();
//		if ( $ip !== '0.0.0.0' ){
//			die('无权访问！');
//		}
	}

	protected function send_state() {
		if(!file_exists($this->lock_file) || time()-filemtime($this->lock_file) > $this->ex_time) {
			return true;
		} else {
			return false;
		}
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */