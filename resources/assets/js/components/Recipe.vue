<template>
	<div class="container">
		<div class="card">
			<h1 class="card-header">
				{{ recipe.name }}
			</h1>
			<ul class="list-group list-group-flush">
				<li class="list-group-item">Id: {{ $route.params.id }}</li>
				<li class="list-group-item">Name: {{ recipe.name }}</li>
				<li class="list-group-item">
					Tags:
					<span v-for="(tag, index) in recipe.tags">
							{{ tag.name }}<span v-if="index < (recipe.tags).length - 1">,&nbsp;</span>
					</span>
				</li>
				<li class="list-group-item">Description: {{ recipe.description }}</li>
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				recipe: {
					name: '',
					description: '',
					tags: [],
				},
				recipeTags: [],
				errors: [],
				update_recipe: {}
			}
		},
		mounted() {
			this.readRecipe();
		},
		methods: {
			readRecipe() {
				axios.get('/recipe/' + this.$route.params.id)
					.then(response => {
						this.recipe = response.data.recipe[0];
					});
			},
		}
	}
</script>

