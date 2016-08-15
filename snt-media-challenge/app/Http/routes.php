<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'listings'], function () {

        /**
        * Listings filtered, paginated route. Returns JSON data
        *
        * Accepted params:
        * per_page(default 10)
        * order_by (list_price) - listingDate was requested but does not exist in the data
        * order_dir (asc|desc) (default desc)
        * photos_only (true)
        *
        * Example Usage:
        * http://sntmediachallenge.local/api/listings/filtered?per_page=2&order_by=list_price&order_dir=desc&photos_only=true
        */
        Route::get('filtered', [
            'as' => 'listings.paged', 'uses' => 'ApiController@showListingsFiltered'
        ]);

        /**
        * Returns all listings includeing photos in JSON
        *
        * Example Usage:
        * http://sntmediachallenge.local/api/listings/all
        */
        Route::get('all', [
            'as' => 'listings', 'uses' => 'ApiController@showListings'
        ]);

        /**
        * Update listing route listing_status. Returns JSON update message on success.
        *
        * Pattern:
        * http://sntmediachallenge.local/api/listings/{mls_number}/{active|inactive}
        *
        * Example Active Toggle Usage:
        * http://sntmediachallenge.local/api/listings/154900/active
        *
        * Example Inactive Toggle Usage:
        * http://sntmediachallenge.local/api/listings/154900/inactive
        */
        Route::get('{mls_number}/{listing_status}', [
            'as' => 'listing.update', 'uses' => 'ApiController@updateListingStatus'
        ])
        ->where('listing_status', 'active|inactive');
    });
});