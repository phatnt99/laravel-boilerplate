<?php


namespace App\Queries\Exceptions;


use Illuminate\Support\Collection;

class InvalidSortQuery extends InvalidQuery
{
    /**
     * @var string
     */
    private $unknownSort;

    /**
     * @var Collection
     */
    private $allowedSorts;

    public function __construct(string $unknownSort, Collection $allowedSorts)
    {
        parent::__construct();
        $this->unknownSort = $unknownSort;
        $this->allowedSorts = $allowedSorts;
        $allowedSorts = $this->allowedSorts->implode(', ');
        $this->message = "Sort by `{$unknownSort}` are not allowed. Allowed sort are `{$allowedSorts}`.";
    }

    public static function sortNotAllowed(string $unknownSort, Collection $allowedSorts)
    {
        return new static(...func_get_args());
    }
}