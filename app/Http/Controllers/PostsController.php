<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use App\Models\PostMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->
        only(['create', 'destroy', 'edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $posts = Post::orderBy('updated_at', 'desc')->paginate(20);

        return view('blog.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        $request->validated();

        $post = Post::create([
            'user_id'=> Auth::id(),
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $this->storeImage($request),
            'is_published' => $request->is_published === 'on',
            'min_to_read' => $request->min_to_read
        ]);
        $post->meta()->create([
            'post_id'=>$post->id,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords,
            'meta_robots'=>$request->meta_robots,
        ]);

        return redirect(route('blog.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return view('blog.show', [
            'post' => Post::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('blog.edit', [
            'post'=> Post::where('id', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        $request->validated();
        Post::where('id', $id)->update($request->except(['_token', '_method', 'meta_description',
            'meta_keywords', 'meta_robots', 'title']));
        PostMeta::where('post_id', $id)->update([
            'meta_description' => $request['meta_description'],
            'meta_keywords' => $request['meta_keywords'],
            'meta_robots' => $request['meta_robots']
        ]);
        return redirect(route('blog.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);
        return redirect(route('blog.index'))->with('message','Post has been deleted');
    }
    private function storeImage($request)
    {
        $newImageName = uniqid() . '-' . $request->title . '.' .
            $request->image->extension();

        return $request->image->move(public_path('images'), $newImageName);
    }
}
