<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


/*
|--------------------------------------------------------------------------
| Eloquent Relationships
|--------------------------------------------------------------------------
*/

// One to one relationships

Route::get('/user/{id}/post', function($id){
    return User::find($id)->post->content;
});

Route::get('/post/{id}/user', function($id){
    return Post::find($id)->user->name;
});

// One to many relationships

Route::get('/post/{id}/user', function($id){
    return Post::find($id)->user->name;
});

Route::get('/posts', function(){

    $user = User::find(1);

    foreach($user->posts as $post){
        echo $post->title . "<br>";
    }
});


/*
|--------------------------------------------------------------------------
| CRUD | Application Routes
|--------------------------------------------------------------------------
*/

//Insert into database
Route::get('/insert', function(){
    DB::insert('INSERT INTO posts(title, content) VALUES(?, ?)',['PHP is awesome','PLA PLA PLA PLA PLA PLA']);
});

//Read from database
Route::get('/read', function(){
    $res =  DB::select('SELECT * FROM posts WHERE id = ?', [1]);

    foreach($res as $post){
        return $res;
    }
});

//Update database
Route::get('/update', function(){
    $update =  DB::update('UPDATE posts SET title = "Updated title" WHERE id = ?', [1]);
        return $update;
});

//Delete from database
Route::get('/delete', function(){
    $delete =  DB::delete('DELETE FROM posts WHERE id = ?', [5]);
        return $delete;
});

//Find from database
Route::get('/find', function(){
    $posts = Post::find(1);
    return $posts->title;
});

//FindWhere

Route::get('/findwhere', function(){
    
    $posts = Post::where('id',2)->orderby('id', 'desc')->take(1)->get();

    return $posts;
});

//Basic Insert
Route::get('/basicinsert', function(){
    
    $post = new Post;

    $post->title = '3rd Laravel title';
    $post->content = 'PLA PLA PLA PLA PLA PLA PLA';

    $post->save();
});

//Basic Update 
Route::get('/basicupdate', function(){
    
    $post = Post::find(1);

    $post->title = 'Updated 1st Laravel title';
    $post->content = 'PLA PLA PLA PLA PLA PLA PLA';

    $post->save();
});

// Create method
Route::get('/create', function(){

    Post::create(['title'=>'the create method', 'content'=>'PLA PLA PLA PLA PLA PLA']);

});


// Update method
Route::get('/newupdate', function(){

    Post::where('id', 1)->update(['title'=>'the create method', 'content'=>'PLA PLA PLA PLA PLA PLA']);

});

// Delete method
Route::get('/delete', function(){

    $post = Post::find(1);
    $post->delete();
});


// Delete method 2
Route::get('/delete2', function(){

    Post::destroy(4);
});

// Soft Delete
Route::get('/softdelete', function(){

    Post::find(5)->delete();
});

// Reading Soft Delete 
Route::get('/readsoftdelete', function(){

    // $post = Post::withTrashed()->where('id',5)->get();
    // return $post;

    $post = Post::onlyTrashed()->where('id',5)->get();
    return $post;
});

// Restoring Soft Delete 
Route::get('/restore', function(){

    Post::withTrashed()->where('id',5)->restore();

});

// Force  Delete 
Route::get('/forcedelete', function(){

    Post::onlyTrashed()->where('id',5)->forceDelete();
    
});