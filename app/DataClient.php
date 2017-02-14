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

    
    public function security()
    {
        return $this->hasMany("App\\Client" . ucfirst(strtolower($this->security_type)) . "Allow", 'client_id', 'id');

    }
    
    
    public function save(array $options = [])
    {
        Redis::hMSet($this->table."::".$this->token, [
            'client_id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'token' => $this->token,
            'security' => $this->security_type,
        ]);

        return parent::save($options);
    }

    public function delete()
    {
        Redis::del($this->table."::".$this->token);
        return parent::delete();
    }


}