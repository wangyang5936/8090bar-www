<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author : Lensic
 * Blog   : http://lensic.sinaapp.com/
 */
 
/*
 * 扩展 Loader 类
 */
class MY_Loader extends CI_Loader
{
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * 设置前端视图路径
	 * 
	 * $template : 模板名
	 */
	function set_template($template)
	{
        $this->_ci_view_paths = array($template . '/' => TRUE);
	}
	
	/*
	 * 设置后端视图路径
	 * 
	 * $template : 模板名
	 */
	function set_admin_template($template)
	{
		$temp = array_keys($this->_ci_view_paths);
        $this->_ci_view_paths = array($temp[0] . $template . '/' => TRUE);
	}
}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */