<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class IdsCasts implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get($model, string $key, mixed $value, array $attributes): array
    {
        return collect(json_decode($value, true))->collapse()->toArray();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, string $key, mixed $value, array $attributes): string
    {

        return json_encode($value);
    }
}
