<?php

namespace App\Services;

class ApiControllerService
{

    public function photosOnly($listings)
    {
        $listings_json =  $listings->toJson();
        $listings = json_decode($listings_json);
        $new_data = [];
        foreach ($listings->data as $listing) {
            $new_data[] = (object) [
                'mls_number' => $listing->mls_number,
                'listing_photos' => $listing->listing_photos,
            ];
        }
        $listings->data = $new_data;

        return $listings;
    }
}
