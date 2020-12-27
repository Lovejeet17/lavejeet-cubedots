<?php

namespace App\Lib\Crud;

use App\Models\Post;
use App\Models\Tag;
use Image;

class PostHelper
{
    public static function getAllPosts($tagId = null) : object
    {
        try{
            
            if($tagId === null) {
                $posts = Post::paginate(6);
            } else {
                $posts = Tag::where('tags.id', $tagId)
                ->leftJoin('post_tag', 'tags.id', '=', 'post_tag.tag_id')
                ->leftJoin('posts', 'post_tag.post_id', '=', 'posts.id')
                ->paginate(6);
                
            }

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

                $img = Image::make($image->getRealPath());
                if (!file_exists(storage_path('app/public/thumbnails'))) {
                    mkdir(storage_path('app/public/thumbnails'), 666, true);
                }
                $img->resize(100, 100, function($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/thumbnails'). '/' .$name);

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

            if(!empty($input['tags'])) {

                $tags = explode(',', $input['tags']);

                $tagIds = self::storeTags($tags);

                $post->tags()->sync($tagIds);
            } else {
                $post->tags()->sync([]);
            }

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

    public static function storeTags($tags = []) : array
    {
        try{
            
            $tagIds = [];

            foreach($tags as $tag) {
                $tagRes = Tag::updateOrCreate([
                    'name' => $tag
                ]);
                array_push($tagIds, $tagRes->id);
            }

            return $tagIds;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getAllTags() : object
    {
        try{
            
            $tags = Tag::all();

            return $tags;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}