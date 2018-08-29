<?php

use Illuminate\Database\Seeder;

class RecipeTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 1,
				'tag_id' => 1,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 2,
				'tag_id' => 1,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 2,
				'tag_id' => 2,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 3,
				'tag_id' => 2,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 3,
				'tag_id' => 3,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 4,
				'tag_id' => 3,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 4,
				'tag_id' => 4,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 5,
				'tag_id' => 3,
			]
		);
		DB::table('recipe_tag')->insert(
			[
				'recipe_id' => 5,
				'tag_id' => 5,
			]
		);
    }
}
