<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
       
        $posts = Post::all();
        $posts = Post::simplePaginate(5); 


        return view('posts.index', compact('posts'));
    }
}
