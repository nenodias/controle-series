<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Episode;
use App\Models\Series;
use App\Models\Season;

class EloquentSeriesRepository implements SeriesRepository
{

    public function add(SeriesFormRequest $request):Series
    {
        $data = $request->all();
        $data['cover'] = $request->coverPath;
        $serie = DB::transaction(function() use ($request, $data){
            $serie = Series::create($data);
            $seasons = [];
            for($i = 1; $i <= $request->seasonsQty; $i++){
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach($serie->seasons as $season){
                for($j = 1; $j <= $request->episodesPerSeason; $j++){
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number'=> $j,
                    ];
                }
            }
            Episode::insert($episodes); 
            return $serie;
        });
        //DB::beginTransaction();
        // DOING SOMETHING
        //DB::commit();
        return $serie;
    }
}
