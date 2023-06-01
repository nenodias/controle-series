<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeasonsController {

    public function show(Series $series)
    {
        return $series->seasons;
    }

}