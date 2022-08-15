<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redis;


class PersonController extends Controller
{

    /**
     * Create a new flight instance.
     *
     * @param Request $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(Request $request): View
    {
        $birthYear = $request->query('birthYear', null);
        $birthMonth = $request->query('birthMonth', null);
        $limit = $request->query('rowLimit', config('config.PAGINATION_LIMIT'));
        $cacheExpiresIn = config('config.CACHE_EXPIRES_IN');
        $initTime = microtime(true);
        $cacheKey = $this->getCacheKey($birthYear, $birthMonth);

        # Result
        $results = $this->cacheOrQuery($cacheKey, $cacheExpiresIn, $birthYear, $birthMonth);
        $collection = collect($results);
        $persons = CollectionHelper::paginate($collection, $limit, $birthYear, $birthMonth);

        # Response
        $difference = round(microtime(true) - $initTime,3)*1000;
        return view('persons', compact('persons', 'limit', 'difference'));
    }


    /**
     * @param $cacheKey
     * @param $cacheExpiresIn
     * @param $birthYear
     * @param $birthMonth
     * @return mixed
     */
    private function cacheOrQuery($cacheKey, $cacheExpiresIn, $birthYear, $birthMonth): mixed
    {
        $data = Redis::get($cacheKey);
        if (!empty($data)){
            return json_decode($data, FALSE);
        }else{
            $data = $this->dbQuery($birthYear, $birthMonth);
            Redis::set($cacheKey, json_encode($data) );
            Redis::expire($cacheKey, $cacheExpiresIn);
        }
        return $data;
    }

    /**
     * @param $birthYear
     * @param $birthMonth
     * @return array
     */
    private function dbQuery($birthYear, $birthMonth): array
    {
        $query = DB::table('persons');
        if ($birthYear != null){
            $query = $query->whereYear('birth_date', $birthYear);
        }
        if ($birthMonth != null){
            $query = $query->whereMonth('birth_date', $birthMonth);
        }
        return $query->get()->toArray();
    }

    /**
     * @param $birthYear
     * @param $birthMonth
     * @return string
     */
    private function getCacheKey($birthYear, $birthMonth): string
    {
        $cacheKey = 'persons';
        return $cacheKey."_".$birthYear."_".$birthMonth;
    }


}

