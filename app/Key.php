<?php
/**
 * Created by PhpStorm.
 * User: kirill_ch
 * Date: 17.02.17
 * Time: 10:54
 */

namespace App;


class Key
{
    private $_instance = null;
    private function __construct(){}

    public function instance()
    {
        if(is_null($this->_instance))
        {
            $this->_instance = new self;
        }

        return $this->_instance;
    }

    public static function requestsHash($client_id, $redis_day)
    {
        return "client::$client_id::stat::$redis_day";
    }

    public static function dataHash($client_id, $redis_day)
    {
        return "client::$client_id::data::stat::$redis_day";
    }

    public static function client($client_token)
    {
        return "client::$client_token";
    }

    public static function clientSecurityItems($client_id, $security_type)
    {
        return "client::".$client_id."::".$security_type."::allow";
    }

    public static function clientAllowedDMPs($client_id)
    {
        return "client::".$client_id."::dmp::allow";
    }


}