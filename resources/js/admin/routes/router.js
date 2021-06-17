import VueRouter from'vue-router';
import Home from '../views/home/Index';
import Categories from '../views/categories/Index';
import Products from '../views/products/Index';

Vue.use(VueRouter);

export default new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/admin/home',
			name: 'home',
			component: Home
		},
		{
			path: '/admin/categories',
			name: 'categories',
			component: Categories
		},
		{
			path: '/admin/products',
			name: 'products',
			component: Products
		}
	]
});
