<?php

namespace App\Queries;

use App\Models\User;
use App\Queries\Builder as CustomBuilder;

class UserQuery extends QueryBuilder
{
    public function __construct()
    {
        // get query builder of model
        $user = new User;
        $query = new CustomBuilder($user->getConnection()
                                        ->query());
        $query->setModel($user);
        parent::__construct($query);
    }

    // ======================================================================
    // Filters
    // ======================================================================
    public function filterById(string $id)
    {
        return $this->filterPartial('id', $id);
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