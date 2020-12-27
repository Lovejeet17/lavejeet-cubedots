<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if(!empty($user['role_id']) && in_array($user['role_id'],[1,2]))
        {

            if(!empty($request->route('slug'))){

                $postUserId = self::getUserIdByPostSlug($request->route('slug'));
                
                if($user['role_id'] === 1 || $user['id'] === $postUserId) {

                    return $next($request);

                }

                return route('login');
            }

            return $next($request);

        } else {
            return route('login');
        }

    }

    public static function getUserIdByPostSlug($slug) : int
    {
        try{
            
            $postUser = Post::where('slug', $slug)
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->first(['posts.slug', 'users.id'])->toArray();

            return $postUser['id'];

        } catch (\Exception $e) {
            \Log::error($e->getMessage(). " ~ " . $e->getFile() . " ~ " . $e->getLine());
        }
    }
}