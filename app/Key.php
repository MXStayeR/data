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

}