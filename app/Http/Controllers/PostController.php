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
            })->paginate(5);

        return view('posts.index', compact('posts', 'keyword'));
    }

    public function create(Request $request)
    {
        $title = $request->query('title', old('title'));
        $description = $request->query('description', old('description'));

        return view('posts.create', compact('title', 'description'));
    }

    public function confirm(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'description' => 'required|min:10',
        ]);

        return view('posts.confirm', [
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'description' => 'required|min:10',
        ]);

        Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'create_user_id' => auth()->user()->id,
            'updated_user_id' => auth()->id(),

        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }
    public function confirmEdit(Request $request, $id)
    {
        $message = [
            'title.required' => 'Title cannot be blank.',
            'descripton.required' => 'Description cannot be blank',
            'description.max' => 'The description should not exceed 500 characters.',
        ];

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $id,
            'description' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ], $message);

        $post = Post::findOrFail($id);

        $status = $request->has('status') ? 1 : 0;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->status = $status;

        return view('posts.confirm-edit', compact('post'));
    }
    public function update(Request $request, $id)
    {

        $post = Post::findOrFail($id);
        $status = $request->has('status') ? 1 : 0;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->status = $status;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {

        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

}
