<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Imports\PostsImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
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
            'updated_user_id' => auth()->user()->id,

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

    $status = $request->input('status'); 
    
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
        return view('posts.index', compact('post'));
    }

    public function importcsv()
    {
        return view('upload');
    }
    public function upload(Request $request)
    {

        $message = [
            'file.required' => 'File cannot be blank.',
            'file.mimes' => 'Only CSV files are allowed.',
        ];

        $request->validate([
            'file' => 'required|mimes:csv|max:10240',
        ], $message);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');

            $handle = fopen($file->getRealPath(), 'r');
            if ($handle) {
                $rowNumber = 0;
                $invalidRowFound = false;

                while (($data = fgetcsv($handle)) !== false) {
                    $rowNumber++;

                    if (count($data) !== 3) {
                        $invalidRowFound = true;
                        Log::error('Row ' . $rowNumber . ' has an invalid number of columns: ', $data);
                        break;
                    }

                    $title = $data[0];
                    $description = $data[1];
                    $status = $data[2];

                    $adminId = Auth::id();

                    $post = new Post();
                    $post->title = $title;
                    $post->description = $description;
                    $post->status = $status;
                    $post->create_user_id = $adminId;
                    $post->updated_user_id = $adminId;
                    $post->created_at = Carbon::now();
                    $post->updated_at = Carbon::now();

                    $post->save();
                }

                fclose($handle);

                if ($invalidRowFound) {
                    return redirect()->back()->with('error', 'Post upload CSV must have 3 columns.');
                }

                return redirect()->back()->with('success', 'File uploaded and processed successfully.');
            }
        }

        return redirect()->back()->with('error', 'File not uploaded.');
    }


    public function download()
    {
        $posts = Post::all();

        $response = new StreamedResponse(function () use ($posts) {

            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Description', 'Status', 'Create_user_id', 'Updated_user_id', 'Created At', 'Updated At', 'Deleted_at']);
            foreach ($posts as $post) {
                fputcsv($handle, [
                    $post->id,
                    $post->title,
                    $post->description,
                    $post->status,
                    $post->create_user_id,
                    $post->updated_user_id,
                    $post->created_at,
                    $post->updated_at,
                    $post->deleted_at,
                ]);
            }
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="posts.csv"');

        return $response;
    }
}
