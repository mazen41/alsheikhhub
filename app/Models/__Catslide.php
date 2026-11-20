<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 * App\Models\Catslide
 *
 * @property int $id
 * @property string $name
 * @property string $category_id
 * @property string|null $logo
 * @property int $top
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide whereTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Catslide whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Catslide extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }
}
