<?php

namespace App\Http\Controllers;

use App\Queries\UserQuery;

class UserController extends Controller
{
    public function __invoke(UserQuery $query)
    {
        $response = $query
            ->filter()
            ->sort()
            ->get(1);

        return response()->json($response);
    }
}
