import user from './modules/user';
import orders from './modules/orders';
import products from './modules/products';
import categories from './modules/categories';

export default new Vuex.Store({
	modules: {
		user,
		orders,
		products,
		categories
	}
});
