<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\ApiControllerService;

use App\Listing;
use App\ListingPhoto;

class ApiController extends Controller
{
    protected $apiControllerService;

    /**
     * Create a new api controller instance.
     *
     * @return void
     */
    public function __construct(apiControllerService $apiControllerService)
    {
        $this->apiControllerService = $apiControllerService;
    }

    /**
     * Display all listings with nested photos.
     *
     * @return \Illuminate\Http\Response
     */
    public function showListings()
    {
        $listings = Listing::with('listingPhotos')->get();
        return response()->json($listings);
    }

    /**
     * Display all listings with filters and pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function showListingsFiltered(Request $request)
    {
        $per_page = $request->input('per_page') ? (int) $request->input('per_page') : 10;
        $order_by = (string) $request->input('order_by');
        $order_dir = $request->input('order_dir') ? (string) $request->input('order_dir') : 'desc';
        $photos_only = (string) $request->input('photos_only');

        try {
            $listings = Listing::with('listingPhotos')
                ->when($order_by, function($query) use ($order_by, $order_dir) {
                    return $query->orderBy($order_by, $order_dir);
                })
                ->paginate($per_page);
            $listings->appends($request->only(['per_page','order_by','order_dir','photos_only']))->links();

        } catch (\Illuminate\Database\QueryException $e) {
            $response = [
                'status' => 'error',
                'message' => 'Bad parameter value.',
            ];
            return response()->json($response);

        } catch (PDOException $e) {
            $response = [
                'status' => 'error',
                'message' => 'Invalid opperation.',
            ];
            return response()->json($response);
        } 

        if ($photos_only) $listings = $this->apiControllerService->photosOnly($listings);

        return response()->json($listings);
    }

    /**
     * Update listing status.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateListingStatus($mls_number, $listing_status)
    {
        $result = Listing::where('mls_number', (int) $mls_number)
            ->update(['listing_status' => (string) $listing_status]);

        $response = [
            'message' => $result ? 'Listing status was update to: ' . (string) $listing_status : 'Listing status was not updated.',
        ];

        return response()->json($response);
    }
}
