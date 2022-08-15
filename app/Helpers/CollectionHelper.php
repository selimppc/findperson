<?php

namespace App\Helpers;


use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CollectionHelper
{

    /**
     * @param Collection $results
     * @param $pageSize
     * @param $birthYear
     * @param $birthMonth
     * @return LengthAwarePaginator
     * @throws BindingResolutionException
     */
    public static function paginate(Collection $results, $pageSize, $birthYear, $birthMonth): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath()."?rowLimit=".$pageSize."&birthYear=".$birthYear."&birthMonth=".$birthMonth,
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param Collection $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param array $options
     * @return LengthAwarePaginator
     * @throws BindingResolutionException
     */
    protected static function paginator(Collection $items, int $total, int $perPage, int $currentPage, array $options): LengthAwarePaginator
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

}
