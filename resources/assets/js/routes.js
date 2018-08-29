import VueRouter from 'vue-router';
import RecipeListing from './components/RecipeListing.vue';
import Recipe from './components/Recipe.vue';
import TagListing from './components/TagListing.vue';

let routes = [
	{
		path: '/',
		component: RecipeListing
	},
	{
		path: '/recipe/:id',
		component: Recipe
	},
	{
		path: '/tags',
		component: TagListing
	}
];

export default new VueRouter({
	routes
});