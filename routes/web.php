<?php

use App\Models\Post;
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
    $post = Post::whereId(2)->get();

    return response()->json($post);
});

Route::get('/findwhere', function () {
    $post = Post::query()->where('title', 'PHP with Laravel')->orderBy('id', 'asc')->get();

    return response()->json($post);
});

Route::get('/basicinsert', function () {
    $post = new Post;
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
// WRONG
//    $post = Post::query()->find(1);
    $post = Post::withTrashed()->where('id', 1)->get();

    $user = new \App\Models\User();

    return response()->json($post);
});
