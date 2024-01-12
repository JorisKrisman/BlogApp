<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
// Delete post function
    public function deletePost(Post $post) {
        if (auth()->user()->id == $post->user_id) {
            $post->delete();
        }      
        return redirect('/');
    }

// Update post function
    public function updatePost(Post $post, Request $request) {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = ($incomingFields['title']);
        $incomingFields['body'] = ($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

// Weergeeft correcte Edit pagina
    public function showEditScreen(Post $post) {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

// creëert nieuwe post
    public function createPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);
        return redirect('/');
    }
}
