<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Post
 *
 * @mixin Builder
 * @property int $id
 * @property string $title
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_admin
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereIsAdmin($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $date = ['deleted_at'];
    protected $fillable = ['title', 'content', 'is_admin'];
}

