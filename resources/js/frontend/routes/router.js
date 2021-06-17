import VueRouter from'vue-router';
import Home from '../views/home/Index';
import Cart from '../views/Cart/Index';
import Checkout from '../views/Checkout/Index';

Vue.use(VueRouter);

export default new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/home',
			name: 'home',
			component: Home
		},
		{
			path: '/cart',
			name: 'cart',
			component: Cart
		},
		{
			path: '/checkout',
			name: 'checkout',
			component: Checkout
		}
	]
});
