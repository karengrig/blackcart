<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * The Store model.
 *
 * @property int $id
 * @property string $platform
 * @property string $driver
 * @property array $configuration
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Store extends Model
{
    /**
     * Fillables of the model.
     *
     * @var string[]
     */
    protected $fillable = [
        'platform',
        'driver',
        'configuration',
    ];

    /**
     * Casts of the model.
     *
     * @var array
     */
    protected $casts = [
        'configuration' => 'array',
    ];
}
