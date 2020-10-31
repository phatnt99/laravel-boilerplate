<?php

namespace App\Queries\Traits;

trait HasAllowAttributes
{
    public function setAllowAttrs($allows)
    {
        $this->allows = $allows;

        return $this;
    }
}