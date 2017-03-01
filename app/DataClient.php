<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class DataClient extends Model
{
    const ON = 1;
    const OFF = 0;

    protected $table = 'data_clients';
    public $primaryKey = 'id';
    public $timestamps = true;

    // Relations:
    public function security()
    {
        return $this->hasMany("App\\Client" . ucfirst(strtolower($this->security_type)) . "Allow", 'client_id', 'id');
    }

    public function allowedDMPs()
    {
        return $this->hasMany("App\\ClientDMPAllow", 'client_id', 'id');
    }


    // Redis implementation
    public function save(array $options = [])
    {
        Redis::hMSet(Key::client($this->token), [
            'client_id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'token' => $this->token,
            'security' => $this->security_type,

            'limit_request' => $this->limit_request,
            'limit_unique_request' => $this->limit_unique_request,
            'limit_response' => $this->limit_response,
            'limit_unique_response' => $this->limit_unique_response,
        ]);

        return parent::save($options);
    }

    public function delete()
    {
        Redis::del(Key::client($this->token));
        Redis::del(Key::clientAllowedDMPs($this->id));
        Redis::del(Key::clientSecurityItems($this->id, $this->security_type));
        return parent::delete();
    }

    // Helpers
    public function hasDMP($dmp_id)
    {
        return ClientDMPAllow::where('client_id', '=', $this->id)->where("dmp_id", "=", $dmp_id)->first();
    }


}
