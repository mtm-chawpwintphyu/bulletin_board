<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class PostController extends Controller
{
    /**
     * Display a listing of the posts, optionally filtered by a keyword.
     * The results are paginated to display 5 posts per page.
     *
     * request object containing the input data, including the 'keyword' for search.
     */
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
    /**
     * Show the form for creating a new post.
     *
     * This method handles displaying the post creation form.
     *
     *request object containing any previous input data.
     *
     *The view for creating a new post with values for the title and description.
     */
    public function create(Request $request)
    {
        $title = $request->query('title', old('title'));
        $description = $request->query('description', old('description'));
        return view('posts.create', compact('title', 'description'));
    }
    /**
     * Validate and show the confirmation page for a new post.
     * This method validates the incoming request data for the `title` and `description` fields. 
     *The request object containing the post data.
     *  The view for confirming the post data with the validated title and description.
     */
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
    /**
     * Store a newly created post in the database.
     *
     * This method validates the incoming request data for the `title` and `description` fields. 
     * it creates a new post in the database 
     * and stores the user's ID for both the `create_user_id` and `updated_user_id` fields. 
     * After the post is successfully created, the user is redirected to the post index page 
     * with a success message.
     */
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
    /**
     *editing the specified post.
     *
     * This method retrieves the post from the database using the given `id`. It then returns the edit view, passing 
     * the retrieved post data to it. If the post with the specified `id` is not found, Laravel will typically 
     * return a 404 error automatically (or you can handle it explicitly).
     *
     * @param int $id The ID of the post to be edited.
     *
     * @return \Illuminate\View\View The view for editing the specified post.
     */
    public function edit($id)
    {
        try {
            // Try to find the post by its ID
            $post = Post::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // If the post doesn't exist, redirect with an error message
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }

        return view('posts.edit', compact('post'));
    }
    public function confirmEdit(Request $request, $id)
    {
        $message = [
            'title.required' => 'Title cannot be blank.',
            'descripton.required' => 'Description cannot be blank',
        ];
        $validated = $request->validate([
            'title' => 'required|string|unique:posts,title,' . $id,
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ], $message);
        $post = Post::findOrFail($id);
        $status = $request->has('status') ? 1 : 0;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->status = $status;
        return view('posts.confirm-edit', compact('post'));
    }
    /**
     * Validate and show the confirmation page for editing a post.
     *
     * This method validates the incoming request data for editing a post, including the `title`, `description`, 
     * and `status` fields.If the validation passes, 
     * it retrieves the post by its `id`, updates the post fields with the validated data, and then shows 
     * the confirmation view with the updated post data.
     *
     * @param \Illuminate\Http\Request $request The request object containing the post data to be validated and edited.
     * @param int $id The ID of the post to be edited.
     *
     * The view for confirming the edit of the post with the updated data.
     */
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
    /**
     * Delete the specified post from the database.
     *
     * This method retrieves the post by its `id` and deletes it from the database. If the post does not exist, 
     * a `ModelNotFoundException` will be thrown. After the deletion, the user is redirected to the post index 
     * page with a success message.
     *
     * @param int $id The ID of the post to be deleted.
     *
     * @return \Illuminate\Http\RedirectResponse The redirect response to the post index page with a success message.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
    /**
     * Display the specified post.
     *
     * This method retrieves a post by its `id` and passes it to the `posts.index` view for display.
     *
     * @param int $id The ID of the post to be displayed.
     *
     * @return \Illuminate\View\View The view displaying the specified post.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.index', compact('post'));
    }
    /**
     * Show the CSV import form.
     * can choose and upload a CSV file to be processed.
     *
     * @return \Illuminate\View\View The view for uploading the CSV file.
     */
    public function importcsv()
    {
        return view('upload');
    }
    /**
     * Handle the CSV file upload and process the data.
     *
     * This method handles the upload of a CSV file, validates it, and processes each row of data.
     * It checks if the CSV file contains the required number of columns (3 columns: title, description, and status).
     * For each valid row, it creates a new post in the database using the data from the CSV file.
     * If the CSV file is valid, the data is stored, and a success message is returned. 
     * If an invalid row is found or the file is not in the correct format, an error message is returned.
     *
     * The request object containing the uploaded file.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response to the previous page with a success or error message.
     *
     * @throws \Illuminate\Validation\ValidationException If the file is invalid (not a CSV or too large).
     */
    public function upload(Request $request)
    {
        $message = [
            'file.required' => 'File cannot be blank.',
            'file.mimes' => 'Only CSV files are allowed.',
            'file.max' => 'The file size exceeds the maximum allowed size of 10MB.',
        ];

        try {
            $request->validate([
                'file' => 'required|mimes:csv|max:10240',
            ], $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'The file is too large to upload. Maximum file size is 10MB.');
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');
            $handle = fopen($file->getRealPath(), 'r');

            if ($handle) {
                $rowNumber = 0;
                $invalidRowFound = false;
                $duplicateTitles = [];

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

                    $existingPost = Post::where('title', $title)->first();
                    if ($existingPost) {
                        $duplicateTitles[] = $title;
                        Log::warning('Duplicate post title found: ' . $title);
                        continue;
                    }

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

                if (!empty($duplicateTitles)) {
                    return redirect()->back()->with('error', 'The following post titles already exist: ' . implode(', ', $duplicateTitles));
                }

                return redirect()->back()->with('success', 'File uploaded and processed successfully.');
            }
        }

        return redirect()->back()->with('error', 'File not uploaded.');
    }
    /**
     * Generate and download a CSV file containing all posts.
     *
     * This method retrieves all posts from the database and streams them as a CSV file for download. 
     * It writes the column headers and the post data into the CSV format, then sends it to the browser 
     * as a downloadable file named `posts.csv`.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse The streamed response for downloading the CSV file.
     */
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
