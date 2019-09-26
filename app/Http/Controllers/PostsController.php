<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$users = auth()->user()->following()->pluck('profiles.user_id');

		// orderBy('created_at', 'DESC') == latest()
		$posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

		//dd($posts);
		return view('posts.index', compact('posts'));
	}

    public function create()
    {
    	return view('posts.create');
    }

    public function store()
    {
    	$data = request()->validate([
    		'caption' => 'required',
    		'image' => 'required|image',
    	]);

    	$imagePath = request('image')->store('uploads', 'public');

    	$image = Image::make(public_path("storage/{$imagePath}"))->fit(450,450);
    	$image->save();

		/* Post::create([
    		'caption' => $data['caption']
    	]); */

    	//$save = Post::create($data);

    	//auth()->user()->posts()->create($data);
    	auth()->user()->posts()->create([
    		'caption' => $data['caption'],
    		'image' => $imagePath,
    	]);

    	//dd(request()->all());

    	return redirect('/profile/' . auth()->user()->id);
    }

    public function show(Post $post)
    {
    	return view('posts.show', compact('post'));
    }
}
