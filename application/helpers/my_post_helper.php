<?php

if ( !defined('BASEPATH') ) exit ( 'No direct script access allowed' );
/**
 * post 提交
 */
function request_by_curl($remote_server, $post_string)
{
    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "8090bar's CURL beta");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
