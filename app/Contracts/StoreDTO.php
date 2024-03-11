<?php

namespace App\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface StoreDTO extends Arrayable
{
    /**
     * Convert the DTO object into array.
     *
     * @return array
     */
    public function toArray(): array;
}
