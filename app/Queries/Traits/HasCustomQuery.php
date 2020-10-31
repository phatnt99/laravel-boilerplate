<?php

namespace App\Queries\Traits;

trait HasCustomQuery
{
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function getCollection() {
        return $this->query->get();
    }
}