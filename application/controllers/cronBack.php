<?php

if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class CronBack extends S_Controller
{

    private $api_key;
    private $secret_key;
    private $redirect_uri;
    private $access_token;

    public function __construct()
    {
        parent::__construct();
        $this->api_key       = $this->config->item('api_key');
        $this->secret_key    = $this->config->item('secret_key');
        $this->refresh_token = $this->config->item('refresh_token');
        $this->redirect_uri  = $this->config->item('base_url') . '/cronBack/callback';
        $this->_get_token();
    }

    public function index()
    {
        //应用根目录
        $root_dir = '/apps/8090bar.com/';

        //上传文件的目标保存路径，此处表示保存到应用根目录下
        $targetPath = $root_dir;
        $date       = date('Ymd');
        $old_date   = date('Ymd', strtotime('-3 day'));
        //要上传的本地文件路径
        $data_file  = '/home/backup/Data_' . $date . '.tar.gz';
        $this->_upload_file($data_file, $targetPath);
        $web_file   = '/home/backup/Web_' . $date . '.tar.gz';
        $this->_upload_file($web_file, $targetPath);
        $del_file   = array('/home/backup/Data_' . $old_date . '.tar.gz', '/home/backup/Web_' . $old_date . '.tar.gz');
        $this->_delete_old_file($del_file);
    }

    public function callback()
    {
        return false;
    }

    /**
     * 上传至百度云
     */
    private function _upload_file($file, $targetPath)
    {
        //文件名称
        $fileName    = basename($file);
        //新文件名，为空表示使用原有文件名
        $newFileName = '';
        $this->load->library('baiduyun/BaiduPCS', array('accessToken' => $this->access_token), 'baidu_pcs');
        if ( !file_exists($file) )
        {
            exit('文件不存在，请检查路径是否正确');
        }
        else
        {
            $fileSize    = filesize($file);
            $handle      = fopen($file, 'rb');
            $fileContent = fread($handle, $fileSize);

            $result = $this->baidu_pcs->upload($fileContent, $targetPath, $fileName, $newFileName);
            fclose($handle);
            echo $result;
        }
    }

    private function _delete_old_file($del_arr)
    {
        $this->load->library('baiduyun/BaiduPCS', array('accessToken' => $this->access_token), 'baidu_pcs');
        $this->baidu_pcs->deleteBatch($del_arr);
    }

    private function _get_token()
    {
        $customer_session_config = array(
            'sess_cookie_name' => 'baidu_token_session',
            'sess_expiration'  => 30 * 24 * 60 * 60 // 保存 29 天
        );
        $this->load->library('session', $customer_session_config, 'baidu_session');
        $access_token            = $this->baidu_session->userdata('access_token');
        if ( !$access_token )
        {
            $this->load->library('baiduyun/BaiduOAuth2', array('clientId' => $this->api_key, 'clientSecret' => $this->secret_key), 'baidu');
            $this->baidu->setRedirectUri($this->redirect_uri);
//            echo $this->baidu->getAuthorizeUrl('code', 'netdisk');
//            $res          = $this->baidu->getAccessTokenByAuthorizationCode('a8ebc399eedba96385a31de0b0ef65b7');
            $res          = $this->baidu->getAccessTokenByRefreshToken($this->refresh_token, 'netdisk');
            $access_token = $res['access_token'];
            $this->baidu_session->set_userdata('access_token', $access_token);
        }
        $this->access_token = $access_token;
    }

}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
