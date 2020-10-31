<?php

namespace App\Queries\Sorts;

use App\Queries\Enums\SortDirection;

class UserSort extends Sort
{
    protected $defaultSorts = [
        //'id' => SortDirection::DESCENDING,
        'name',
        'age' => SortDirection::DESCENDING,
    ];
}