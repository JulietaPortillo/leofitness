<?php

namespace App;

trait createdByUser
{
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}