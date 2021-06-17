import user from './modules/user';
import carts from './modules/carts';
import orders from './modules/orders';
import products from './modules/products';
import categories from './modules/categories';

export default new Vuex.Store({
	modules: {
		user,
		carts,
		orders,
		products,
		categories
	}
});
