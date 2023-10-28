<?php

namespace App\Models;

use Carbon\Carbon;
use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;
use App\Lubus\Constants;

class Subscription extends Model
{
    //Eloquence Search mapping
    use Eloquence;
    use createdByUser, updatedByUser;

    protected $table = 'trn_subscriptions';

    protected $fillable = [
        'member_id',
        'invoice_id',
        'plan_id',
        'status',
        'is_renewal',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['created_at', 'updated_at', 'start_date', 'end_date'];

    protected $searchableColumns = [
        'Member.member_code' => 20,
        'start_date' => 20,
        'end_date' => 20,
        'Member.name' => 20,
        'Plan.plan_name' => 20,
        'Invoice.invoice_number' => 20,
    ];

    public function scopeDashboardExpiring($query)
    {
        return $query
            ->with(['member' => function ($query) {
                $query->where('status', '=', Constants::Active);
            }])
            ->where('end_date', '<', Carbon::today()->addDays(7))
            ->where('status', '=', Constants::onGoing);
    }

    public function scopeDashboardExpired($query)
    {
        return $query
            ->with(['member' => function ($query) {
                $query->where('status', '=', Constants::Active);
            }])
            ->where('status', '=', Constants::Expired);
    }

    public function scopeIndexQuery($query, $sorting_field, $sorting_direction, $drp_start, $drp_end)
    {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')->select('subscriptions.*', 'plans.plan_name')->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')->select('subscriptions.*', 'plans.plan_name')->whereBetween('subscriptions.created_at', [$drp_start, $drp_end])->orderBy($sorting_field, $sorting_direction);
    }

    public function scopeExpiring($query, $sorting_field, $sorting_direction, $drp_start, $drp_end)
    {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')->select('subscriptions.*', 'plans.plan_name')->where('subscriptions.end_date', '<', Carbon::today()->addDays(7))->where('subscriptions.status', '=', Constants::onGoing)->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')->select('subscriptions.*', 'plans.plan_name')->where('subscriptions.end_date', '<', Carbon::today()->addDays(7))->where('subscriptions.status', '=', Constants::onGoing)->whereBetween('subscriptions.created_at', [$drp_start, $drp_end])->orderBy($sorting_field, $sorting_direction);
    }

    public function scopeExpired($query, $sorting_field, $sorting_direction, $drp_start, $drp_end)
    {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')->select('subscriptions.*', 'plans.plan_name')->where('subscriptions.status', '=', Constants::Expired)->where('subscriptions.status', '!=', Constants::renewed)->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')->select('subscriptions.*', 'plans.plan_name')->where('subscriptions.status', '=', Constants::Expired)->where('subscriptions.status', '!=', Constants::renewed)->whereBetween('subscriptions.created_at', [$drp_start, $drp_end])->orderBy($sorting_field, $sorting_direction);
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }
}