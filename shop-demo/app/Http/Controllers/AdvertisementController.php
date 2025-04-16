<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    public function getActiveAdvertisements()
    {
        $today = Carbon::now()->toDateString();

        $advertisements = Advertisement::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        return response()->json($advertisements);
    }
}