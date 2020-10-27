<?php

namespace App\Queries;

use App\Models\User;

class UserQuery extends QueryBuilder
{

    protected $model = User::class;

    // ======================================================================
    // Filters
    // ======================================================================
    public function filterById(string $id)
    {
        return $this->filterExact('id', $id);
    }

    public function filterByName(string $name)
    {
        return $this->filterPartial('name', $name);
    }

    // ======================================================================
    // Sorts
    // ======================================================================
    public function sortByName($direction)
    {
        return $this->query->orderBy('name', $direction);
    }

    public function sortById($direction)
    {
        return $this->query->orderBy('id', $direction);
    }

    public function sortByCreatedAt($direction)
    {
        return $this->query->orderBy('created_at', $direction);
    }

    // ======================================================================
    // Custom Queries
    // ======================================================================
    public function isVerified()
    {
        $this->query->whereNotNull('email_verified_at');

        return $this;
    }
}