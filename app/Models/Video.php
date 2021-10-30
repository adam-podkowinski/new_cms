<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 * @method static Builder|Video newModelQuery()
 * @method static Builder|Video newQuery()
 * @method static Builder|Video query()
 * @method static Builder|Video whereCreatedAt($value)
 * @method static Builder|Video whereId($value)
 * @method static Builder|Video whereName($value)
 * @method static Builder|Video whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Video extends Model
{
    use HasFactory;

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
