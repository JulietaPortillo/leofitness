<?php

namespace App\Models;

use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;
use App\Models\updatedByUser;
use App\Models\createdByUser;

class Plan extends Model
{
    const InActive = 0;
    const Active = 1;
    const Archive = 2;
    protected $table = 'plans';

    protected $fillable = [
        'plan_code',
        'plan_name',
        'service_id',
        'plan_details',
        'days',
        'amount',
        'status',
        'created_by',
        'updated_by',
    ];

    //Eloquence Search mapping
    use Eloquence;
    use createdByUser, updatedByUser;

    protected $searchableColumns = [
        'plan_code' => 20,
        'plan_name' => 10,
        'plan_details' => 5,
    ];

    public function getPlanDisplayAttribute()
    {
        return $this->plan_code.' @ '.$this->amount.' For '.$this->days.' Days';
    }

    public function scopeExcludeArchive($query)
    {
        return $query->where('status', '!=', self::Archive);
    }

    public function scopeOnlyActive($query)
    {
        return $query->where('status', '=', self::Active);
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription', 'plan_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}