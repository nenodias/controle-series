<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController {

    public function __construct(private SeriesRepository $repository)
    {
    }

    public function index(Request $request)
    {
        $query = Series::query();
        if($request->has('nome')){
            $query->where('nome', 'like', $request->nome);
        }
        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request)
    {
        return response()->json($this->repository->add($request), 201);
    }

    public function show(int $series)
    {
        /* Eager loading
        $response = Series::with('seasons.episodes')->whereId($series)->first();
        return response()->json($response, 200);
        */
        $model = Series::find($series);
        if($model === null)
        {
            return response()->json(['message' => 'Series not found'], 404);
        } 
        return $model;
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        // Exemplo de update recebendo o id da série
        //Series::where(‘id’, $series)->update($request->all());
        $series->fill($request->only(['nome']));
        $series->save();
        return $series;
    }

    public function destroy(int $series)
    {
        Series::destroy($series);
        return response()->noContent();
    }
}