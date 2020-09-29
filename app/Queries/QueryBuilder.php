<?php

namespace App\Queries;

use App\Queries\Concerns\FiltersQuery;
use App\Queries\Concerns\PaginationQuery;
use App\Queries\Concerns\SortsQuery;
use App\Queries\Filters\FiltersExact;
use App\Queries\Filters\FiltersPartial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * @mixin Builder
 */
class QueryBuilder
{
    use PaginationQuery;
    use FiltersQuery;
    use SortsQuery;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var Request
     */
    protected $request;

    public function __construct($query, ?Request $request = null)
    {
        $this->query = $query;
        $this->request = $request ?? app(Request::class);
    }

    /**
     * filter exact given value
     *
     * @param string|array $property
     * @param string|array $value
     * @return Builder
     */
    protected function filterExact($property, $value)
    {
        return FiltersExact::apply($this->query, $property, $value);
    }

    /**
     * filter with all potential
     *
     * @param string|array $property
     * @param string|array $value
     * @return Builder|void
     */
    protected function filterPartial($property, $value)
    {
        return FiltersPartial::apply($this->query, $property, $value);
    }
}