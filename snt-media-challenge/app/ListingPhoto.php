<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingPhoto extends Model
{
   public function listing() {
        return $this->belongsTo('App\Listing', 'mls_number', 'mls_number');
    }
}
