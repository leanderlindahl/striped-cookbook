<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
		//
		protected $fillable = [
			'name'
		];


		public function recipes()
		{
			//return $this->belongsToMany('App\Recipe', 'recipe_tag', 'tag_id', 'id');
			return $this->belongsToMany('App\Recipe');
		}
}
