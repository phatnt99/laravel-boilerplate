<?php

namespace App\Queries\QueryBuilders;

use App\Models\User;
use App\Queries\FilterV2\UserFilter;
use App\Queries\Sorts\UserSort;

class UserQuery extends QueryBuilder
{
    /**
     * @var string
     */
    protected $model = User::class;

    /**
     * @var string
     */
    protected $filter = UserFilter::class;

    /**
     * @var string
     */
    protected $sort = UserSort::class;
}