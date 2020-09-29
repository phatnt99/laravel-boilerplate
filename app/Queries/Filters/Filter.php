<?php


namespace App\Queries\Filters;


use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * @param  Builder  $query
     * @param  string  $property
     * @param  mixed  $value
     * @return Builder
     */
    public static function apply(Builder $query, $property, $value);
}