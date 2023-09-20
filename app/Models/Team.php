<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $id
 */
class Team extends Model
{
    use HasFactory;

    public static function create($name, $abbreviation) : static
    {
        $Team = new static();

        $Team->name = $name;
        $Team->abbreviation = $abbreviation;

        if (! $Team->save()) {
            throw new \Exception('dont save team');
        }

        return $Team;
    }
}
