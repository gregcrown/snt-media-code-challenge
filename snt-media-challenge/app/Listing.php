<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_street_address','city','state_or_province','postal_code','country','list_price','listing_url','bedrooms','bathrooms','property_type','listing_key','listing_category','listing_status','listing_description','mls_id','mls_name','mls_number','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $table = 'listings';
}
