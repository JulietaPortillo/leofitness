<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Lubus\Constants;

class Member extends Model
{
use HasFactory;
    protected $table = 'members';

    protected $fillable = [
        'member_code',
        'name',
        'DOB',
        'email',
        'address',
        'status',
        'proof_name',
        'gender',
        'contact',
        'emergency_contact',
        'health_issues',
        'pin_code',
        'occupation',
        'aim',
        'source',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['created_at', 'updated_at', 'DOB'];

    protected $searchableColumns = [
        'member_code' => 20,
        'name' => 20,
        'email' => 20,
        'contact' => 20,
    ];

    public function getDobAttribute($value)
    {
        return (new Carbon($value))->format('Y-m-d');
    }

    //Relationships
    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    //Scope Queries

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($query) use ($searchTerm) {
            foreach ($this->searchableColumns as $column => $weight) {
                $query->orWhere($column, 'LIKE', '%'.$searchTerm.'%');
            }
        });
    }
    public function scopeIndexQuery($query, $sorting_field, $sorting_direction)
    {
        $sorting_field = $sorting_field ?: 'created_at';
        $sorting_direction = $sorting_direction ?: 'desc';
    
        $query->with('subscriptions') // Eager load subscriptions relationship
        ->select('id', 'member_code', 'name', 'contact', 'created_at', 'status')
        ->where('status', '!=', Constants::Archive)
        ->orderBy($sorting_field, $sorting_direction);

    
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', Constants::Active);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', '=', Constants::InActive);
    }

    public function scopeRecent($query)
    {
        return $query->where('created_at', '<=', Carbon::today())->take(10)->orderBy('created_at', 'desc');
    }

    public function scopeBirthday($query)
    {
        return $query->whereMonth('DOB', '=', Carbon::today()->month)->whereDay('DOB', '<', Carbon::today()->addDays(7))->whereDay('DOB', '>=', Carbon::today()->day)->where('status', '=', Constants::Active);
    }

    // Laravel issue: Workaroud Needed
    public function scopeRegistrations($query, $month, $year)
    {
        return $query->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->count();
    }
}