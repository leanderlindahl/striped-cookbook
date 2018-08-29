<?php

use Illuminate\Database\Seeder;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes')->insert(
			[
				'name' => 'Recipe 1',
				'description' => 'Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis.'
			]
		);
		DB::table('recipes')->insert(
			[
				'name' => 'Recipe 2',
				'description' => 'Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis.'
			]
		);
		DB::table('recipes')->insert(
			[
				'name' => 'Recipe3',
				'description' => 'Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis.'
			]
		);
		DB::table('recipes')->insert(
			[
				'name' => 'Recipe 4',
				'description' => 'Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis.'
			]
		);
		DB::table('recipes')->insert(
			[
				'name' => 'Recipe 5',
				'description' => 'Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis.'
			]
		);
    }
}
