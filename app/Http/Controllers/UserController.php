<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Queries\FilterV2\UserFilter;
use App\Queries\QueryBuilders\UserQuery;
use App\Queries\Sorts\UserSort;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke(Request $request, UserQuery $query)
    {
        //return response()->json($sort->apply($request));
        return response()->json($query->filter()
                                      ->sort()
                                      ->paginate(1));
    }

    public function getCollection()
    {
    }
}
