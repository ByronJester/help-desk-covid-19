<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function homeView()
    {
        $user = null;

        if(Auth::user()) {
        	$user = Auth::user();
        }
        
    	return Inertia::render('Home',  
    		[
                'options'    => [
                	'user' => $user,
                    'posts' => Post::orderBy('created_at', 'desc')->get()
                ]
            ]
    	);
    }

    public function savePost(Request $request)
    {
        $user = Auth::user();
        
        $post = new Post();

        if($request->has('id')) {
            $post = Post::where('id', $request->id)->first();
        }

        $post->user_id = $user->id;
        $post->content = $request->content;
        $post->save();

        if($post) {
            if($images = $request->images) {
                foreach ($images as $image) {
                    $path = public_path().'/images/posts';

                    $filename = time() . '_' . Str::random(8);

                    $extension = $image->getClientOriginalExtension();
                    
                    $uplaod = $image->move($path, $filename . '.' . $extension);

                    PostImage::where('post_id', $post->id)->delete();
                    
                    PostImage::create([
                        'post_id' => $post->id,
                        'image'   => $filename . '.' . $extension
                    ]);
                }
            }
        }

        return redirect()->back();
        
    }

    public function deletePost(Request $request)
    {
        $id = $request->id;

        $imageDelete = PostImage::where('post_id', $id)->delete();

        $postDelete = Post::where('id', $id)->delete();

        return redirect()->back();
    }
    
} 
