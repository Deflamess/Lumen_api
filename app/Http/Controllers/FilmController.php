<?php

namespace App\Http\Controllers;

use App\Film;
use App\Services\RestClientInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    private $restClient;

    public function __construct(RestClientInterface $client)
    {
        $this->restClient = $client;
    }


    public function search($film)
    {
       // $filmsInDB = Film::where('title', 'LIKE', $film); //Builder

        $filmsInDB = DB::select("SELECT * FROM films
                              WHERE title LIKE '%" . $film . "%' LIMIT 1"
            );
        if (! empty($filmsInDB) ) {
            $film = $filmsInDB[0];
            unset($film->id);
            unset($film->created_at);
            unset($film->updated_at);
            return response()->json($filmsInDB[0]);
        };
        $url = sprintf('http://www.omdbapi.com/?apikey=%s&t=%s',
                         'dfb1f0ae', $film);
        $result = $this->restClient->get($url);
        if (!isset($result['Title'])) {
            return response()->json([
                'Error' => [
                    'message' => 'Film not found'
                ], Response::HTTP_NOT_FOUND
            ]);
        }

        $result = [
            'title' => $result['Title'],
            'director' => $result['Director'],
            'description' => $result['Plot'],
            'imdb_id' => $result['imdbID']
        ];
        Film::create($result);

        return response()->json($result);
    }
}