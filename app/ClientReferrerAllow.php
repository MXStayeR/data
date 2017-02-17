<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class ClientReferrerAllow extends Model
{
    protected $table = 'client_referrer_allow';
    public $primaryKey = ['client_id', 'referrer'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['referrer'];



    public function save(array $options = [])
    {
        Redis::sAdd(Key::clientSecurityItems($this->client_id, 'referrer'), $this->referrer);
        return parent::save($options);
    }

    public function delete()
    {
        Redis::sRem(Key::clientSecurityItems($this->client_id, 'referrer'), $this->referrer);
        return parent::delete();
    }
}
