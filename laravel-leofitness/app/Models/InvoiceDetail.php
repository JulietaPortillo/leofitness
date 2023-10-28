<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    use createdByUser, updatedByUser;

    protected $table = 'trn_invoice_details';

    protected $fillable = [
        'item_name',
        'plan_id',
        'item_description',
        'invoice_id',
        'item_amount',
        'created_by',
        'updated_by',
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }
}
