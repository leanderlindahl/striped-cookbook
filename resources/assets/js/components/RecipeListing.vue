<template>
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<button @click="initAddRecipe()" class="btn btn-outline-primary btn-xs float-right">
	                    + Add New Recipe
	                </button>
				<h2>My Recipes</h2>
				<table class="table table-bordered table-striped table-responsive w-100 d-block d-md-table" v-if="recipes.length > 0">
					<tbody>
						<tr>
							<th>
								No.
							</th>
							<th>
								Name
							</th>
							<th width="30%">
								Description
							</th>
							<th>
								Tags
							</th>
							<th width="30%">
								Action
							</th>
						</tr>
						<tr v-for="(recipe, index) in recipes">
							<td>{{ index + 1 }}</td>
							<td>
								<router-link :to="`/recipe/${recipe.id}`">
									{{ recipe.name }}
								</router-link>
							</td>
							<td>
								<router-link :to="`/recipe/${recipe.id}`">
									{{ recipe.description }}
								</router-link>
							</td>
							<td>
								<span v-for="(tag, index) in recipe.tags">
	                                    {{ tag.name }}
	                                    <span v-if="index < (recipe.tags).length - 1">,&nbsp;</span>
								</span>
							</td>
							<td>
								<button @click="readRecipe(index)" class="btn btn-outline-primary btn-xs">View</button>
								<button @click="initUpdate(index)" class="btn btn-outline-success btn-xs">Edit</button>
								<button @click="deleteRecipe(index)" class="btn btn-outline-danger btn-xs">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>
	
			</div>
			<div class="col-md-3">
				<div class="card">
					<div class="card-header">
						Filter by Tag
					</div>
	
					<span v-for="(tag, index) in tags">
	                        <!-- <router-link :to="`/tagged-with/${tag.id}`" > -->
	
	                        <!-- {{ tag.name }}&nbsp;<span class="badge badge-primary">10</span> -->
					<button @click="filterRecipes(tag.id)" class="btn btn-outline-primary btn-xs float-left" :disabled="processing">{{ tag.name }}</button>
					<!-- </router-link> -->
					</span>
	
				</div>
			</div>
		</div>
	
		<div class="modal fade" tabindex="-1" role="dialog" id="add_recipe_model">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add New Recipe</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
					</div>
					<div class="modal-body">
	
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
	
						<div class="form-group">
							<label for="name">Name:</label>
							<input type="text" name="name" id="name" placeholder="Recipe Name" class="form-control" v-model="recipe.name">
						</div>
	
						<div class="form-group">
							<label for="tags">Tags:</label>
							<multiselect v-model="recipe.recipeTags" track-by="name" label="name" placeholder="Select one" :options="tags" :multiple="true" :hide-selected="true" :taggable="true">
							</multiselect>
						</div>
						<div class="form-group">
							<label for="description">Description:</label>
							<textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Recipe Description" v-model="recipe.description"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-default" data-dismiss="modal">Close</button>
						<button type="button" @click="createRecipe" class="btn btn-outline-primary">Submit</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
	
		<div class="modal fade" tabindex="-1" role="dialog" id="update_recipe_model">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Update Recipe</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
					</div>
					<div class="modal-body">
	
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
	
						<div class="form-group">
							<label>Name:</label>
							<input type="text" placeholder="Recipe Name" class="form-control" v-model="update_recipe.name">
						</div>
						<div class="form-group">
							<label for="tags">Tags:</label>
							<multiselect v-model="update_recipe.tags" track-by="name" label="name" placeholder="Select one" :options="tags" :multiple="true" :hide-selected="true" :taggable="true">
							</multiselect>
						</div>
						<div class="form-group">
							<label for="description">Description:</label>
							<textarea cols="30" rows="5" class="form-control" placeholder="Recipe Description" v-model="update_recipe.description"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-default" data-dismiss="modal">Close</button>
						<button type="button" @click="updateRecipe" class="btn btn-outline-primary">Submit</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
	</div>
</template>

<script>
	import Multiselect from "vue-multiselect";
	export default {
		components: {
			Multiselect
		},
		data() {
			return {
				recipe: {
					name: "",
					description: "",
					recipeTags: [],
					tags: []
				},
				errors: [],
				recipes: [],
				tags: [],
				filteredId: "",
				update_recipe: {},
				processing: false
			};
		},
		mounted() {
			this.readRecipes();
		},
		methods: {
			initAddRecipe() {
				$("#add_recipe_model").modal("show");
			},
			createRecipe() {
				let tagIdArray = [];
				for (let i = 0; i < this.recipe.recipeTags.length; i++) {
					tagIdArray[i] = this.recipe.recipeTags[i].id;
				}
				axios.post("/recipe", {
						name: this.recipe.name,
						//recipeTags: this.recipe.recipeTags,
						recipeTags: tagIdArray,
						description: this.recipe.description
					}).then(response => {
						// Keep the new tag(s) before resetting 'this'
						response.data.recipe.tags = this.recipe.recipeTags;
						this.reset();
						this.recipes.push(response.data.recipe);
						$("#add_recipe_model").modal("hide");
					})
					.catch(error => {
						this.errors = [];
						if (error.response.data.errors.name) {
							this.errors.push(error.response.data.errors.name[0]);
						}
	
						if (error.response.data.errors.recipeTags) {
							this.errors.push(error.response.data.errors.recipeTags[0]);
						}
	
						if (error.response.data.errors.description) {
							this.errors.push(error.response.data.errors.description[0]);
						}
					});
			},
			reset() {
				this.recipe.name = "";
				this.recipe.recipeTags = [];
				this.recipe.description = "";
			},
			readRecipe(index) {
				const show_recipe_id = this.recipes[index].id;
				this.$router.push({
					path: "/recipe/" + show_recipe_id
				});
			},
			readRecipes() {
				axios.get("/recipe").then(response => {
					this.recipes = response.data.recipes;
					this.tags = response.data.tags;
				});
			},
			filterRecipes(tagId) {
				if (this.filteredId !== tagId) {
					this.filteredId = tagId;
					axios.get("/recipe/filter/" + tagId).then(response => {
						this.recipes = response.data.recipes;
					});
				} else {
					this.filteredId = "";
					axios.get("/recipe").then(response => {
						this.recipes = response.data.recipes;
					});
				}
			},
			initUpdate(index) {
				this.errors = [];
				$("#update_recipe_model").modal("show");
				this.update_recipe = this.recipes[index];
			},
			updateRecipe() {
				let updateTagIdArray = [];
				for (let i = 0; i < this.update_recipe.tags.length; i++) {
					updateTagIdArray[i] = this.update_recipe.tags[i].id;
				}
	
				axios
					.patch("/recipe/" + this.update_recipe.id, {
						name: this.update_recipe.name,
						// recipeTags: this.update_recipe.recipeTags,
						recipeTags: updateTagIdArray,
						description: this.update_recipe.description
					})
					.then(response => {
						$("#update_recipe_model").modal("hide");
					})
					.catch(error => {
						this.errors = [];
						if (error.response.data.errors.name) {
							this.errors.push(error.response.data.errors.name[0]);
						}
	
						if (error.response.data.errors.recipeTags) {
							this.errors.push(error.response.data.errors.recipeTags[0]);
						}
	
						if (error.response.data.errors.description) {
							this.errors.push(error.response.data.errors.description[0]);
						}
					});
			},
			deleteRecipe(index) {
				let conf = confirm("Do you ready want to delete this recipe?");
				if (conf === true) {
					axios
						.delete("/recipe/" + this.recipes[index].id)
						.then(response => {
							this.recipes.splice(index, 1);
						})
						.catch(error => {});
				}
			}
		}
	};
</script>