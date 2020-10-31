<?php

namespace App\Queries;

use Phatnt99\QueryBuilder\QueryBuilder;
use App\Models\Some;
use App\Queries\Filters\SomeFilter;
use App\Queries\Sorts\SomeSort;

class SomeQuery extends QueryBuilder
{
    	/**
    	 * Your model class
         * @var string
         */
        protected $model = Some::class;

        /**
         * Your filter class
         * @var string
         */
        protected $filter = SomeFilter::class;

        /**
         * Your sort class
         * @var string
         */
        protected $sort = SomeSort::class;
}
