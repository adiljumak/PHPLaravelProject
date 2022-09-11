<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function index()
    {

        //$data = $request->validated();
        //dd($data);

        $posts  = Post::paginate(10);
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post.create', compact('categories', 'tags'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('post.index');
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();

        $this->service->update($post, $data);


        return redirect()->route('post.show', $post->id);
    }

    public function delete()
    {
        $post = Post::withTrashed()->find(6);
        $post->restore();
        dd('deleted');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }

    public function firstOrCreate()
    {

        $anotherPost = [
            'title' => 'SOME312321321',
            'content' => 'SHIDIRUSOME312321321',
            'image' => 'www.example.com/exmpl.png',
            'likes' => 912220,
            'is_published' => 1,
        ];

        $myPost = Post::firstOrCreate([
            'title' => 'SOME312321321',
        ], [
            'title' => 'SOME312321321',
            'content' => 'SHIDIRUSOME312321321',
            'image' => 'www.example.com/exmpl.png',
            'likes' => 912220,
            'is_published' => 1,
        ]);
        dump($myPost->content);
        dd('finished');
    }

    public function updateOrCreate()
    {

    }

}
