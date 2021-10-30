<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_admin
 * @property Carbon|null $deleted_at
 * @property-read Collection|Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read User $user
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|Post onlyTrashed()
 * @method static Builder|Post query()
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDeletedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereIsAdmin($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Post withoutTrashed()
 * @mixin Eloquent
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $date = ['deleted_at'];
    protected $fillable = ['title', 'content', 'is_admin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

