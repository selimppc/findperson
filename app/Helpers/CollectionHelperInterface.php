<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CollectionHelperInterface
{
    /**
     * @param Collection $results
     * @param int $pageSize
     * @param $birthYear
     * @param $birthMonth
     * @return LengthAwarePaginator
     */
    public static function paginate(Collection $results, int $pageSize, $birthYear, $birthMonth): LengthAwarePaginator;

    /**
     * @param Collection $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param array $options
     * @return LengthAwarePaginator
     */
    public static function paginator(Collection $items, int $total, int $perPage, int $currentPage, array $options): LengthAwarePaginator;
}
