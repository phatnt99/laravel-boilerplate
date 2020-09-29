<?php

namespace App\Queries\Concerns;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @property Request $request
 * @property Builder $query
 */
trait PaginationQuery
{
    /**
     * @return LengthAwarePaginator|Collection
     */
    public function allowPaginate()
    {
        if (! $this->hasPaginate()) {
            return $this->query->get();
        }

        return $this->query->paginate(
            $this->request->input('per_page', $this->query->getModel()->getPerPage()),
            ['*'],
            'page',
            $this->request->input('number', 1)
        );
    }

    /**
     * @return bool
     */
    protected function hasPaginate()
    {
        return $this->request->has('per_page') || $this->request->has('page');
    }
}