<?php

namespace App\Models;

trait createdByUser
{
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}