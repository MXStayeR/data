<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class DataClient extends Model
{
    protected $table = 'data_clients';
    public $primaryKey = 'id';
    public $timestamps = true;


    /**
     * @param array $options
     * @return integer
     */

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

    /**
     * @return mixed
     * @throws \Exception
     */

    public function delete()
    {
        Redis::del($this->table."::".$this->token);
        return parent::delete();
    }


}
