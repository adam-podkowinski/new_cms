<?php

/*
 * DATABASE RAW QUERIES
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/insert/', function () {
    DB::insert('INSERT INTO posts(title, content) values(?, ?)', ['PHP with Laravel', 'Laravel is good']);
});

Route::get('/read/{id}', function ($id) {
    $result = DB::select('select * from posts where id = ?', [$id]);

    foreach ($result as $post) {
        return response()->json($post);
    }

    return response()->json(['error' => 'Post with an id of 1 not found.'], 404);
});

Route::get('/update', function () {
    $updated = DB::update('update posts set title=? where id=?', ['Updated title', 1]);
    return response()->json($updated);
});

Route::get('/delete', function () {
    $deleted = DB::delete('delete from posts where id = ?', [1]);

    return response()->json($deleted);
});
