<?php

namespace Tests\Feature;

use App\Http\Requests\SeriesFormRequest;
use App\Repositories\EloquentSeriesRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created(): void
    {
        //Arrange
        /** @var SeriesRepository $repository */
        $repository = $this->app->make(SeriesRepository::class);
        $request = new SeriesFormRequest([
            "nome" => $this->faker()->name(),
            "seasonsQty" => "1",
            "episodesPerSeason" => "1",
        ]);
        Log::info($request);

        //Act
        $repository->add($request);

        //Assert
        $this->assertDatabaseHas('series', ['nome' => $request->nome]);
        $this->assertDatabaseHas('seasons', ['number' => 1]);
        $this->assertDatabaseHas('episodes', ['number' => 1]);
    }
}
