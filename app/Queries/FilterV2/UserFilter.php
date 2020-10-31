<?php

namespace App\Queries\FilterV2;

class UserFilter extends Filter
{
    protected $filterPartial = [
        'name',
    ];

    protected $filterExact = [
        'age',
    ];

    protected $filterDate = [
        'email_verified_at',
    ];

    protected function complex($value)
    {
        // something more complex than exact, partial or date..
    }
}