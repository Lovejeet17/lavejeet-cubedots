<?php

namespace App\Lib\Crud;

use App\Models\Post;

class PostHelper
{
    public static function getAllPosts() : object
    {
        try{
            
            $posts = Post::paginate(6);

            return $posts;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getPost($slug) : object
    {
        try{
            
            $postData = Post::where('slug', $slug)->first();

            return $postData;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function store($request, $user) : object
    {
        try{

            $input = $request->all();

            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $image->move(storage_path('app/public/images'), $name);
            } else {
                $name = null;
            }

            $post = Post::updateOrCreate(
                [
                    'user_id' => $user['id'],
                    'slug' => $input['slug']
                ],
                [
                    'title' => $input['title'],
                    'description' => $input['description'],
                    'featured_image' => $name
                ]
            );

            return $post;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function delete($slug) : bool
    {
        try{

            return Post::where('slug', $slug)->delete();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}