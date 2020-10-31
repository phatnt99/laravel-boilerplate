<?php

namespace App\Queries\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class Filter
{
    protected $attributes = [];

    protected $model = Model::class;

    protected $query;

    /**
     * Filter constructor.
     */
    public function __construct()
    {
        $this->query = User::query();
    }

    public abstract function attributes();

    public function convert()
    {
        $filterable = array_intersect_key($this->attributes(), $this->attributes);

        foreach ($filterable as $filter => $callback) {
            ($callback)($this->query, $filter, Arr::get($this->attributes, $filter));
        }

        return $this->query->get();
    }

    public function filter(Request $request) {
        $this->addRequestParamsToFilter($request);
        return $this->convert();
    }

    public function addRequestParamsToFilter(Request $request) {
        $this->attributes = $request->input('filters', []);
    }
}