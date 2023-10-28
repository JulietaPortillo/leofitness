<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;
use DB;

class Service extends Model
{
    //Eloquence Search mapping
    use Eloquence;
    use createdByUser, updatedByUser;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];


    protected $searchableColumns = [
        'name' => 20,
        'description' => 10,
    ];

    public static function getAllServices()
    {
        return self::all();
    }

    public function plans()
    {
        return $this->hasMany('App\Models\Plan', 'service_id');
    }
}