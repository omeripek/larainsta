<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
    	$user = User::findOrFail($user)->first();
		$follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
		
		$postCount = Cache::remember('count.posts', now()->addSeconds(30), function () use($user) {
			return $user->posts->count();
		});

		$followerCount = Cache::remember('count.followers', now()->addSeconds(30), function () use($user) {
			return $user->profile->followers->count();
		});

		$followingCount = Cache::remember('count.following', now()->addSeconds(30), function () use($user){
			return $user->following->count();
		});
    	
    	return view('profiles.index', compact('user', 'follows', 'postCount', 'followerCount', 'followingCount'));
    	/* return view('profiles.index',[
    		'user' => $user
    	]);*/
    }

    public function edit(User $user)
    {
    	$this->authorize('update', $user->profile);
    	return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
    	$this->authorize('update', $user->profile);
    	$data = request()->validate([
    		'title' => 'required',
    		'description' => 'required',
    		'url' => 'url',
    		'image' => '',
    	]);


    	if(request('image')){
    		$imagePath = request('image')->store('profile', 'public');

	    	$image = Image::make(public_path("storage/{$imagePath}"))->fit(700,700);
	    	$image->save();

	    	/*auth()->user()->profile->update(array_merge(
	    		$data,
	    		['image' => $imagePath]
    		));*/
    		$imageArray = ['image' => $imagePath];
    	}
    	/*else {
    		auth()->user()->profile->update($data);
    	}
		*/
		
		auth()->user()->profile->update(array_merge(
	    		$data,
	    		$imageArray ?? []
    		));

    	return redirect("/profile/{$user->id}");
    }
}
