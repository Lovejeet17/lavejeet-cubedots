<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Lib\Crud\PostHelper;

class PostController extends Controller
{
    public function __construct()
    {
        try
        {
            $this->middleware('auth');
        } catch (\Exeption $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }
    }

    /**
     * list of all posts
     */
    public function show($tagId = null)
    {
        try
        {

            $posts = PostHelper::getAllPosts($tagId);

            $tags = PostHelper::getAllTags();

            return view('posts', compact('posts'), compact('tags'));

        } catch (\Exeption $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }
    }

    /**
     * create post page
     */
    public function create()
    {
        try
        {

            return $this->edit(0);

        } catch (\Exeption $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }
    }

    /**
     *  edit or read post page
     */
    public function edit($slug)
    {
        try
        {
            $post = [];

            if($slug !== 0) {
                $post = PostHelper::getPost($slug);
            }

            return view('edit', compact('post'));

        } catch (\Exeption $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }
    }

    /**
     * store or edit post data
     */
    public function store(Request $request)
    {
        try{
            
            $user = auth()->user();
            $post = PostHelper::store($request, $user);

            return redirect()->to('post/'.$post['slug']);

        } catch (\Exeption $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }
    }

    /**
     * soft delete post
     */
    public function delete($slug)
    {
        try{
            
            $post = PostHelper::delete($slug);

            return redirect()->to('posts');

        } catch (\Exeption $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }   
    }
}
