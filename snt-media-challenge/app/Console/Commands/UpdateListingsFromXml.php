<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Listing;
use App\ListingPhoto;

class UpdateListingsFromXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update listings from XML data via URL';

    protected $listing;
    protected $listingPhoto;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Listing $listing, listingPhoto $listingPhoto)
    {
        parent::__construct();
        $this->listing = $listing;
        $this->listingPhoto = $listingPhoto;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $xml_data_url = "https://sntmedia.atlassian.net/wiki/download/attachments/4358316/listings.xml?version=1&modificationDate=1455562119802&api=v2&download=true";
        $xml_string = file_get_contents($xml_data_url);
        $xml_data = simplexml_load_string($xml_string);

        $listings = [];
        $listing_photos = [];
        $mls_numbers = [];

        foreach ($xml_data->Listing as $listing) {
            $namespaces = $listing->getNameSpaces(true);
            $item = [
                'full_street_address' => $listing->Address->children('commons', true)->FullStreetAddress,
                'city' => $listing->Address->children('commons', true)->City,
                'state_or_province' => $listing->Address->children('commons', true)->StateOrProvince,
                'postal_code' => $listing->Address->children('commons', true)->PostalCode,
                'country' => $listing->Address->children('commons', true)->Country,
                'list_price' => $listing->ListPrice,
                'listing_url' => $listing->ListingURL,
                'bedrooms' => $listing->Bedrooms,
                'bathrooms' => $listing->Bathrooms,
                'property_type' => $listing->PropertyType,
                'listing_key' => $listing->ListingKey,
                'listing_category' => $listing->ListingCategory,
                'listing_status' => $listing->ListingStatus,
                'listing_description' => $listing->ListingDescription,
                'mls_id' => $listing->MlsId,
                'mls_name' => $listing->MlsName,
                'mls_number' => $listing->MlsNumber,
            ];
            $listings[] = $item;
            foreach ($listing->Photos->children() as $photo) {
                $modified_datetime = date("Y-m-d H:i:s", strtotime($photo->MediaModificationTimestamp));
                $photo_data = [
                    'mls_number' => $item['mls_number'],
                    'media_modification_timestamp' => $modified_datetime,
                    'media_url' => $photo->MediaURL,
                ];
                $photos[] = $photo_data;
            }
            $mls_numbers[] = $item['mls_number'];
        }

        $this->listing->whereIn('mls_number', $mls_numbers ? $mls_numbers : [0])->delete();
        $this->listingPhoto->whereIn('mls_number', $mls_numbers ? $mls_numbers : [0])->delete();

        $this->listing->insert($listings);
        $this->listingPhoto->insert($photos);
    }
}
