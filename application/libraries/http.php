<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of http
 *
 * @author wangyang
 */
class Http
{

    /**
     * @var  array  default header options
     */
    public static $default_options = array(
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4',
        'Connection' => 'Close' //Need to close the request every time for HTTP 1.1
    );

    /**
     * return Array lines of headers
     * Overwrite by $options
     *
     * @param Array $options, key value pairs of Header options
     * 
     * @return Array,Array line of headers
     */
    private static function getHeaders($options)
    {
        if ( $options === NULL )
        {
            // Use default options
            $options = self::$default_options;
        }
        else
        {
            //Merge the $options with $default_options, if the value set in $options,
            //Value in $default_options will be overwrite
            $options = $options + self::$default_options;
        }

        $headers = array();
        foreach ( $options as $k => $v )
        {
            $headers[] = $k . ': ' . $v;
        }

        return $headers;
    }

    /**
     * Returns the output of a http URL. 
     * may be used.
     *
     * @param   string   http base URL or FULL url
     * @param   array    Header options
     * @param   array $data Get Param
     * @param   array &$reponse header, if Assigned,the response header will be populated
     *
     * @return  string, Raw String of Http body
     */
    public static function get($url, array $options = NULL, $data = NULL, &$response_header = NULL)
    {
        $headers = self::getHeaders($options);
        $params  = array('http' => array(
                'method'           => 'GET',
                //Defautl HTTP 1.1 and with Connection Close
                'protocol_version' => '1.1'
        ));

        if ( $options !== null )
        {
            $params['http']['header'] = $headers;
        }

        if ( $data )
        {
            $url .= '?' . http_build_query($data);
        }
        $ctx = stream_context_create($params);
        $fp  = fopen($url, 'rb', false, $ctx);
        if ( !$fp )
        {
            throw new Exception("Connection failed: $url");
        }

        if ( $response_header !== NULL )
        {
            $response_header = stream_get_meta_data($fp);
        }

        $response = stream_get_contents($fp);
        if ( $response === false )
        {
            throw new Exception("Reading data Failed: $url");
        }
        fclose($fp);
        return $response;
    }

    /**
     * Post with request options and data 
     *
     * @param String url, FULL url
     * @param Array $options , key=>value pairs array
     * @param Array $data ,Post Data pairs
     * @param   array &$reponse header, if Assigned,the response header will be populated
     *
     * @return  string, Raw String of Http body
     */
    public static function post($url, $options = null, $data = NULL, &$response_header = NULL)
    {
        //Restricted the Form formate
        if ( is_array($data) )
        {
            $data = http_build_query($data);
        }

        $options['Content-type']   = 'application/x-www-form-urlencoded';
        $options['Content-Length'] = strlen($data);

        $params = array('http' => array(
                'method'  => 'POST',
                'content' => $data
        ));

        $headers                  = self::getHeaders($options);
        $params['http']['header'] = $headers;

        $ctx = stream_context_create($params);
        $fp  = fopen($url, 'rb', false, $ctx);
        if ( !$fp )
        {
            throw new Exception("Connection Failed: $url ");
        }

        if ( $response_header !== NULL )
        {
            $response_header = stream_get_meta_data($fp);
        }

        $response = stream_get_contents($fp);
        if ( $response === false )
        {
            throw new Exception("Reading data failed: $url");
        }
        fclose($fp);
        return $response;
    }

    /**
     * Inflate zipped content
     *
     * @param String $_content, gzipped content
     *
     * @return String, Inflated content
     */
    public static function inflate($_content)
    {
        //deflate add 10 charaters before inflate format and 8 charaters checksum append
        //gzdecode is not availible for ALL PHP even gzencode is avalible
        $_content = substr($_content, 10, -8);
        return gzinflate($_content);
    }

    /**
     * Check if the reponse content is zipped from response header
     *
     * @param Array $_response_header, Response header captured from get/post
     *
     * @return Boolean, True for zipped contented
     */
    public static function isZipped($_response_header)
    {
        if ( preg_grep('/^Content-Encoding:\s*gzip/', $_response_header['wrapper_data']) )
        {
            return TRUE;
        }
        else
        {
            return False;
        }
    }

}
