<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
		
	// public function __construct()
	// {
	// 		$this->middleware('auth');
	// }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$recipes = Recipe::all();
		$tags = Tag::all();

		return response()->json([
				'recipes'    => $recipes,
				'tags'       => $tags,
		], 200);
	}

	public function filterByTag($tagId)
    {

			$recipes = Tag::findOrFail($tagId)->recipes;
			
			$tags = Tag::all();

			return response()->json([
					'recipes'    => $recipes,
			], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
				//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
			'description' => 'required',
        ]);
		
		$recipe = Recipe::create([
            'name'        => request('name'),
            'description' => request('description'),
        ]);

		$recipe->tags()->sync($request->recipeTags, false);
				
        return response()->json([
            'recipe'    => $recipe,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
			$recipe = Recipe::where(['id' => $id])->get();

			return response()->json([
					'recipe'    => $recipe,
					// 'recipeTags' => $tags,
			], 200);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
			$this->validate($request, [
					'name'        => 'required|max:255',
					'description' => 'required',
			]);

			$recipe->name = request('name');
			$recipe->description = request('description');
			$recipe->save();
			$recipe->tags()->detach();
			$recipe->tags()->sync($request->recipeTags, false);

			return response()->json([
					'message' => 'Recipe updated successfully!'
			], 200);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
			$recipe->tags()->detach();			

      $recipe->delete();
			return response()->json([
					'message' => 'Recipe deleted successfully!'
			], 200);
	}
}
