<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;

class Recipe extends Model
{	
	protected $with = ['tags'];

	protected $fillable = [
		'name',
		'user_id',
		'description',
		'tag'
	];

	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}
}
