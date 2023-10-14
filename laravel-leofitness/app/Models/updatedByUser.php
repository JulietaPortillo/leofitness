<?php

namespace App;

trait updatedByUser
{
    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
}