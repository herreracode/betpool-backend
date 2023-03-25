<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class Team extends Model
{
    use HasFactory;

    public static function create($name) : static
    {
        $Team = new static();

        $Team->name = $name;

        if (! $Team->save()) {
            throw new \Exception('dont save team');
        }

        return $Team;
    }
}
