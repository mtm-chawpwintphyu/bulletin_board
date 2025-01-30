<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::query()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('title', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            })->paginate(5);  // Paginate the results

        return view('posts.index', compact('posts', 'keyword'));
    }

    public function create(Request $request)
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.required' => 'Title cannot be blank.',
            'description.required' => 'Description cannot be blank.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'description.string' => 'Description must be a valid string.',
        ]);

        // Temporarily store data in variables (instead of session)
        $title = $request->input('title');
        $description = $request->input('description');

        return redirect()->route('posts.confirm', compact('title', 'description'));
    }
    public function confirm(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');

        return view('posts.confirm', compact('title', 'description'));
    }

    public function storeFinal(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create the post
        Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'create_user_id' => Auth::id(),
            'updated_user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index');
    }

    public function edit($id)
    {
        // Find the post by ID or fail if not found
        $post = Post::findOrFail($id);

        // Return the edit view with the post data
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean', 
        ]);

        $post = Post::findOrFail($id);

        // Update post with the new title, description, and status
        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->status = $request->has('status') ? 1 : 0; 
        $post->updated_user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }






    public function show($id)
    {
        // Retrieve the post by ID or fail if not found
        $post = Post::findOrFail($id);

        // Return the view and pass the post data
        return view('posts.show', compact('post'));
    }

}
