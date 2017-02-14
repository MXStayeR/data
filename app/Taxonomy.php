<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $connection = 'banner';
    protected $table = 'dmp_taxonomy';
    public $primaryKey = ['id', 'dmp_id'];
    public $incrementing = false;
    public $timestamps = false;

    public static function getDmpTaxonomy($dmp_id, $tax_id)
    {
        return self::where("id", "=", $tax_id)->where("dmp_id", "=", $dmp_id)->first();
    }


    public function save(array $options = [])
    {
        // Переопределен для отключения изменений
        return true;
    }

    public function delete()
    {
        // Переопределен для отключения изменений
        return true;
    }
}
