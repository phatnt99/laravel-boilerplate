<?php

namespace App\Http\Controllers;

use App\Queries\UserQuery;

class UserController extends Controller
{
    public function __invoke(UserQuery $query)
    {
        $response = $query
            ->allowFilterBy([
                'name',
                'id',
            ])->allowSortBy([
                'name',
                'created_at',
                'id'
            ])->allowPaginate();

        return response()->json($response);
    }
}
