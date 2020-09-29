<?php


namespace App\Queries\Exceptions;


use Illuminate\Support\Collection;

class InvalidFilterQuery extends InvalidQuery
{
    /**
     * @var string
     */
    private $unknownFilter;

    /**
     * @var Collection
     */
    private $allowedFilters;

    public function __construct(string $unknownFilter, Collection $allowedFilters)
    {
        parent::__construct();
        $this->unknownFilter = $unknownFilter;
        $this->allowedFilters = $allowedFilters;
        $allowedFilters = $this->allowedFilters->implode(', ');
        $this->message = "Filter by `{$unknownFilter}` are not allowed. Allowed filter are `{$allowedFilters}`.";
    }

    public static function filterNotAllowed(string $unknownFilter, Collection $allowedFilters)
    {
        return new static(...func_get_args());
    }
}