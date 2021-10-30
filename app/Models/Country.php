<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Post[] $posts
 * @property-read int|null $posts_count
 * @property-read User|null $user
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Country extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function posts() {
        return $this->hasManyThrough(Post::class, User::class);
    }
}
