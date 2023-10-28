<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class ChequeDetail extends Model
{
    use HasFactory;
     //Eloquence Search mapping
     use Eloquence;
     use updatedByUser;
 
     protected $table = 'trn_cheque_details';
 
     protected $fillable = [
             'payment_id',
             'number',
             'date',
             'status',
             'created_by',
             'updated_by',
      ];
 
     protected $searchableColumns = [
         'number' => 20,
     ];
 
     public function createdBy()
     {
         return $this->belongsTo('App\Models\User', 'created_by');
     }
 
     public function payment()
     {
         return $this->belongsTo('App\Models\PaymentDetail', 'payment_id');
     }
}
