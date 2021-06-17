import products from '../../api/products'

// initial state
const state = {
	all: []
};

// getters
const getters = {
	all: state => state.all,
};

// actions
const actions = {
	getProducts ({ commit }, data) {
		return new Promise(function (resolve, reject) {
			products.getProducts(products => {
				commit('setProducts', products)
			}, data, resolve, reject);
		});
	},
};

// mutations
const mutations = {
	setProducts (state, products) {
		state.all = products
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
