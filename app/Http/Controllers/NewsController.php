<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post ;
use App\Comment ;
use App\User ;
use Illuminate\Support\MessageBag ;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Create Fake Post
        Post::factory()->count(6)->for(User::factory())->create() ;
        // Query To Database
        $posts = Post::orderBy('created_at' , 'desc')->limit(30)->get() ;
        $newestPosts = Post::orderBy('created_at' , 'desc')->limit(4)->get() ;
        $mostVisitedPosts = Post::orderBy('view' , 'desc')->limit(6)->get() ;
        // Return View
        return view('news.index' , compact('posts' , 'newestPosts' , 'mostVisitedPosts')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'email' =>  ['required','string','email','max:255'] ,
            'body' =>   ['required' ,'string','min:10','max:255'],
            'post_id' => ['required','numeric']
        ]) ;
        // Store New Comment
        Comment::create($request->all()) ;
        // Success Massage
        $successMsg = [ 'successMsg' => 'Create comment successfully.' ] ;
        // Return Redirect View
        return redirect()->back()->withErrors($successMsg) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // Update View Post
        $post->view = $post->view + 1 ;
        $post->save() ;
        $post =Post::with('user' , 'comments')->find($post->id) ;
        // Return View
        return view('news.article' , compact('post')) ;
    }

}
