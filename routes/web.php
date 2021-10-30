<?php

use App\Models\Country;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
 * DATABASE RAW QUERIES
 */

Route::get('/insert', function () {
    DB::insert('INSERT INTO posts(title, content) values(?, ?)', ['PHP with Laravel', 'Laravel is good']);
});

Route::get('/read/{id}', function ($id) {
    $result = DB::select('select * from posts where id = ?', [$id]);

    foreach ($result as $post) {
        return response()->json($post);
    }

    return response()->json(['error' => 'Post with an id of 1 not found.'], 404);
});

Route::get('/updateRaw', function () {
    $updated = DB::update('update posts set title=? where id=?', ['Updated title', 1]);
    return response()->json($updated);
});

Route::get('/deleteRaw', function () {
    $deleted = DB::delete('delete from posts where id = ?', [1]);

    return response()->json($deleted);
});

/*
 * ELOQUENT
 */

Route::get('/findAll', function () {
    $posts = Post::all();

    foreach ($posts as $post) {
        return response()->json($post);
    }

    return response()->json(['error' => 'error not found 404'], 404);
});

Route::get('/find', function () {
    $post = Post::whereId(2)->first();

    return response()->json($post);
});

Route::get('/findwhere', function () {
    $post = Post::query()->where('title', 'new title')->orderBy('id', 'asc')->get();

    return response()->json($post);
});

Route::get('/basicinsert', function () {
    $post = new Post();
    $post->title = 'new title';
    $post->content = 'new content';
    $post->save();
});

Route::get('/basicupdate/{id}', function ($id) {
    $post = Post::whereId($id)->firstOrFail();
    $post->title = 'new ' . $id;
    $post->content = $id . ' content';
    $post->save();
});

Route::get('/create', function () {
    Post::query()->create(['title' => 'the title', 'content' => 'WOW Content', 'is_admin' => 1]);
});


Route::get('/update', function () {
    Post::query()->where('is_admin', 0)->update(
        [
            'title' => 'idof2',
            'content' => 'id2and is admin 0'
        ]
    );
});

Route::get('/deleteAll', function () {
    $posts = Post::all();
    foreach ($posts as $post) {
        $post->delete();
    }
});

Route::get('/delete', function () {
    Post::destroy(7);
});

Route::get('/deleteMany', function () {
    Post::destroy([4, 5]);
});

Route::get('/softdelete', function () {
    Post::query()->findOrFail(3)->deleteOrFail();
});

Route::get('/readsoftdeleted', function () {
    $post = Post::withTrashed()->where('id', 1)->get();

    return response()->json($post);
});

Route::get('/restore', function () {
    Post::withTrashed()->where('is_admin', 0)->restore();
});

Route::get('/forcedelete', function () {
    Post::onlyTrashed()->where('is_admin', 0)->forceDelete();
});

/*
 * ELOQUENT RELATIONSHIPS
 */

// One to one relationship
Route::get('/user/{id}/post', function ($id) {
    return User::whereId($id)->firstOrFail()->post;
});

Route::get('/post/{id}/user', function ($id) {
    return Post::whereId($id)->firstOrFail()->user->name;
});

// One to many relationship
Route::get('/user/{id}/posts', function ($id) {
    return User::whereId($id)->firstOrFail()->posts;
});

Route::get('/user/{id}/roles', function ($id) {
    $return = [];
    $userRoles = User::whereId($id)->firstOrFail()->roles;

    foreach ($userRoles as $role) {
        array_push($return, $role['name']);
    }

    return $return;
});

Route::get('/roles/{id}', function ($id) {
    return Role::whereId($id)->firstOrFail()->users;
});

Route::get('/user/pivot', function () {
    $user = User::whereId(1)->firstOrFail();
    $return = [];

    foreach ($user->roles as $role) {
        array_push($return, $role->pivot);
    }

    return $return;
});

Route::get('/user/{id}/country', function ($id) {
    return User::whereId($id)->firstOrFail()->country;
});

Route::get('/posts/{id}', function ($id) {
    return Country::whereId($id)->firstOrFail()->posts;
});

Route::get('/country/{id}/user', function ($id) {
    $country = Country::whereId($id)->firstOrFail();
    $return = [];

    foreach ($country->posts as $post) {
        array_push($return, $post);
    }

    return $return;
});

Route::get('/user/{id}/photos', function ($id) {
    $user = User::whereId($id)->firstOrFail();
    $return = [];

    foreach ($user->photos as $photo) {
        array_push($return, $photo);
    }

    if (empty($return)) {
        return response()->json(['error' => 'not found'], 404);
    } else {
        return $return;
    }
});

Route::get('/photo/{id}/imageable', function ($id) {
    $photo = Photo::whereId($id)->firstOrFail();
    return $imageable = $photo->imageable;
});

Route::get('/post/{id}/tag', function ($id) {
    $post = Post::whereId($id)->firstOrFail();
    $return = [];

    foreach ($post->tags as $tag) {
        array_push($return, $tag);
    }

    if (empty($return)) {
        return response()->json(['error' => 'not found'], 404);
    } else {
        return $return;
    }
});

Route::get('/tag/{id}/posts', function ($id) {
    $tag = Tag::whereId($id)->firstOrFail();
    $return = [];

    foreach ($tag->posts as $tag) {
        array_push($return, $tag);
    }

    if (empty($return)) {
        return response()->json(['error' => 'not found'], 404);
    } else {
        return $return;
    }
});

Route::get('/tag/{id}/videos', function ($id) {
    $tag = Tag::whereId($id)->firstOrFail();
    $return = [];

    foreach ($tag->videos as $tag) {
        array_push($return, $tag);
    }

    if (empty($return)) {
        return response()->json(['error' => 'not found'], 404);
    } else {
        return $return;
    }
});
