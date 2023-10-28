<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class PaymentDetail extends Model
{
    use HasFactory;
    //Eloquence Search mapping
    use Eloquence;
    use createdByUser,updatedByUser;

    protected $table = 'trn_payment_details';

    protected $fillable = [
        'payment_amount',
        'note',
        'mode',
        'invoice_id',
        'created_by',
        'updated_by',
    ];

    protected $searchableColumns = [
        'payment_amount' => 20,
        'Invoice.invoice_number' => 20,
        'Invoice.member.name' => 20,
    ];

    public function scopeIndexQuery($query, $sorting_field, $sorting_direction, $drp_start, $drp_end)
    {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('trn_invoice', 'trn_payment_details.invoice_id', '=', 'trn_invoice.id')->leftJoin('members', 'trn_invoice.member_id', '=', 'members.id')->select('trn_payment_details.id', 'trn_payment_details.created_at', 'trn_payment_details.payment_amount', 'trn_payment_details.mode', 'trn_payment_details.invoice_id', 'trn_invoice.invoice_number', 'members.id as member_id', 'members.name as member_name', 'members.member_code')->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('trn_invoice', 'trn_payment_details.invoice_id', '=', 'trn_invoice.id')->leftJoin('members', 'trn_invoice.member_id', '=', 'members.id')->select('trn_payment_details.id', 'trn_payment_details.created_at', 'trn_payment_details.payment_amount', 'trn_payment_details.mode', 'trn_invoice.invoice_number', 'members.name as member_name', 'members.member_code')->whereBetween('trn_payment_details.created_at', [
                $drp_start,
                $drp_end,
            ])->orderBy($sorting_field, $sorting_direction);
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id');
    }

    public function cheque()
    {
        return $this->hasOne('App\Models\ChequeDetail', 'payment_id');
    }
}
