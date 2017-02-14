<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DMP extends Model
{
    protected $connection = 'banner';
    protected $table = 'dmp';
    public $primaryKey = 'dmp_id';
    public $timestamps = false;

    public function taxonomies()
    {
        return $this->hasMany("App\\Taxonomy", 'dmp_id', 'dmp_id');
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
