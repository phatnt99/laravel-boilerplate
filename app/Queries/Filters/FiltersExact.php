<?php


namespace App\Queries\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class FiltersExact implements Filter
{
    /**
     * @param  Builder  $query
     * @param  string  $property
     * @param  mixed  $value
     * @return Builder
     */
    public static function apply(Builder $query, $property, $value)
    {
        if (Str::of($value)->contains(',')) {
            return $query->whereIn($property, explode(',', trim($value)));
        }
        return $query->where($property, '=', $value);
    }
}