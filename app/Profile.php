<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

	protected $guarded = [];

	public function profileImage()
	{
		$imagePath = ($this->image) ? url('') . '/storage/' . $this->image : url('') . '/img/no-image.jpeg';
		return $imagePath;
	}

	public function followers()
	{
		return $this->belongsToMany(User::class);
	}

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
}
