<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment ;
use App\Post ;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\MessageBag ;
use Illuminate\Support\Facades\DB ;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::inspect('viewAny' , Comment::class)->allowed()){
            // Create Fake Comment
            Comment::factory()->count(1)->for(Post::factory()->for(User::factory()))->create() ;
            // Query To Database
            $comments = Comment::with('post')->get() ;
            // Return View
            return view('admin.comments' , compact('comments')) ;
        }else{
            abort(403) ;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        // Delete The Specified Comment
        $comment->delete() ;
        // Success Massage
        $successMsg = [ 'successMsg' => 'Delete Comment successfully.' ] ;
        // Return Redirect View
        return redirect()->back()->withErrors($successMsg) ;
    }
}
