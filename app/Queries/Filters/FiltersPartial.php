<?php


namespace App\Queries\Filters;


use Illuminate\Database\Eloquent\Builder;

class FiltersPartial implements Filter
{

    /**
     * @param  Builder  $query
     * @param  string  $property
     * @param  mixed  $value
     * @return Builder|void
     */
    public static function apply(Builder $query, $property, $value)
    {
        $wrappedProperty = $query->getQuery()->getGrammar()->wrap($property);
        $sql = "LOWER({$wrappedProperty}) LIKE ?";
        if (is_array($value)) {
            if (count(array_filter($value)) === 0) {
                return;
            }
            return $query->where(function (Builder $query) use ($value, $sql) {
                foreach (array_filter($value) as $partialValue) {
                    $partialValue = mb_strtolower($partialValue, 'UTF8');
                    $query->orWhereRaw($sql, ["%{$partialValue}%"]);
                }
            });
        }
        $value = mb_strtolower($value, 'UTF8');
        return $query->whereRaw($sql, ["%{$value}%"]);
    }
}