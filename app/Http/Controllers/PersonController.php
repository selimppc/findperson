<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class PersonController extends Controller
{

    /**
    * Create a new flight instance.
    *
    * @param  Request  $request
    * @return View
     */
    public function index(Request $request): View
    {
        $birthYear = $request->input('birthYear', $request->query('birthYear', null));
        $birthMonth = $request->input('birthMonth', $request->query('birthMonth', null));
        $limit = $request->input('rowLimit', $request->query('rowLimit', config('config.PAGINATION_LIMIT')));
        $cache_expires_id = config('config.CACHE_EXPIRES_IN');
        $initTime = microtime(true);
        $cacheKey = $this->getCacheKey($request, $birthYear, $birthMonth);

        # Result
        $persons = $this->cacheOrQuery($cacheKey, $cache_expires_id, $birthYear, $birthMonth, $limit);

        # Response
        $difference = round(microtime(true) - $initTime,3)*1000;
        return view('persons', compact('persons', 'limit', 'difference'));

    }


    /**
     * @param $cacheKey
     * @param $cache_expires_id
     * @param $birthYear
     * @param $birthMonth
     * @param $limit
     * @return mixed
     */
    private function cacheOrQuery($cacheKey, $cache_expires_id, $birthYear, $birthMonth, $limit): mixed
    {
        dump($cacheKey);
        return Cache::remember($cacheKey, $cache_expires_id, function () use($birthYear, $birthMonth, $limit) {
            return $this->dbQuery($birthYear, $birthMonth, $limit);
        });

    }

    /**
     * @param $birthYear
     * @param $birthMonth
     * @param $limit
     * @return LengthAwarePaginator
     */
    private function dbQuery($birthYear, $birthMonth, $limit): LengthAwarePaginator
    {
        dump($birthYear);
        dump($birthMonth);
        dump($limit);
        $query = DB::table('persons');
        if ($birthYear != null){
            $query = $query->whereYear('birth_date', $birthYear);
        }
        if ($birthMonth != null){
            $query = $query->whereMonth('birth_date', $birthMonth);
        }
        $query = $query->paginate($limit);
        $query->appends (array ('birthYear' => $birthYear, 'birthMonth' => $birthMonth));
        return $query;
    }

    /**
     * @param $request
     * @param $birthYear
     * @param $birthMonth
     * @return string
     */
    private function getCacheKey($request, $birthYear, $birthMonth): string
    {
        $cacheKey = 'persons';
        if ($request->isMethod('POST')){
            $cacheKey = $cacheKey."_".$birthYear."_".$birthMonth;
        }
        return $cacheKey;
    }

}

