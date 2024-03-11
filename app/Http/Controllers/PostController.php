<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\PostCreated;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('post.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
        ]);

        // Create a new instance of the Post model and fill it with the validated data
        $post = new Post();
        $post->name = $validatedData['name'];
        $post->about = $validatedData['about'];

        // Save the post to the database
        $post->save();
        $data = ['title'=>$post_data['title'], 'auther'=>auth()->user()->name()];
        event(new PostCreated($data));

        // Redirect back with a success message or any other desired response
        return redirect()->back()->with('success', 'Post created successfully!');
    }

    // Other methods...
}
