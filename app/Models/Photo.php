<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Photo
 *
 * @property int $id
 * @property string $path
 * @property int $imageable_id
 * @property string $imageable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Photo newModelQuery()
 * @method static Builder|Photo newQuery()
 * @method static Builder|Photo query()
 * @method static Builder|Photo whereCreatedAt($value)
 * @method static Builder|Photo whereId($value)
 * @method static Builder|Photo whereImageableId($value)
 * @method static Builder|Photo whereImageableType($value)
 * @method static Builder|Photo wherePath($value)
 * @method static Builder|Photo whereUpdatedAt($value)
 * @property-read Model|Eloquent $imageable
 * @mixin \Eloquent
 */
class Photo extends Model
{
    use HasFactory;

    public function imageable()
    {
        return $this->morphTo();
    }
}
