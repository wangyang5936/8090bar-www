<?php

if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

/*
 * Author : wangyang
 */

/*
 * 站点标题
 */
$config['web_title'] = 'Power By wangyang';

/*
 * 前台视图模板文件夹，位于根目录 themes/ 下
 */
$config['web_template'] = 'default';

/*
 * 后台视图模板文件夹，位于 application/views/ 下
 */
$config['web_admin_template'] = 'default';

/*
 * 外部资源文件夹，位于根目录下
 */
$config['web_resource'] = 'resources';

/*
 * 上传文件夹，位于根目录下
 */
$config['web_upload'] = 'uploads';

/*
 * 自定义密码加密密钥
 *
 * web_encryption_key_begin : 2, 4, 6, 8, 10, 12 位分离往后组合，组合成 beginningcoding
 * web_encryption_key_end   : 2, 4, 6 位分离往前组合。组合成 endcoding
 */
$config['web_encryption_key_begin'] = '8090';
$config['web_encryption_key_end']   = 'bar';


/*
 * 邮件属性设置
 *
 * web_email_from    : 来自
 * web_email_name    : 名称
 */
$config['web_email_from'] = '59369025@qq.com';
$config['web_email_name'] = 'yang';

/*
 * 验证码图片属性配置
 *
 * web_captcha_img_path   : 在 $config['web_upload'] 下的文件名
 * web_captcha_expiration : 过期时间s
 */
$config['web_captcha_img_path']   = 'captcha';
$config['web_captcha_expiration'] = 60;

/*
 * kindeditor 文件上传属性配置
 *
 * web_kindeditor_upload_path : kindeditor 上传路径，在 $config['web_upload'] 下的文件名
 * web_kindeditor_upload_size : kindeditor 上传大小(B)，默认为 1M
 */
$config['web_kindeditor_upload_path'] = 'kindeditor';
$config['web_kindeditor_upload_size'] = 1048576;

/**
 * 百度云配置
 */
$config['api_key']       = 'RBR9HUcgyBCTstliBezYL2za';
$config['secret_key']    = 'I6xuaCGX7wk957s1gp3USkeuFTThRFDY';
$config['refresh_token'] = '22.cc10e7812b4e061d8deaa8a16337086d.315360000.1720780111.1929778555-1270506';

/* End of file web_config.php */
/* Location: ./application/config/web_config.php */