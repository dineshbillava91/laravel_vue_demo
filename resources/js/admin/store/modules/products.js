import products from '../../api/products'

// initial state
const state = {
	all: {
		data: []
	}
};

// getters
const getters = {
	all: state => state.all,
};

// actions
const actions = {
	getProducts ({ commit }) {
		return new Promise(function (resolve, reject) {
			products.getProducts(products => {
				commit('setProducts', products)
			}, resolve, reject);
		});
	},

	addProduct({ commit }, data) {
		return new Promise(function (resolve, reject) {
			products.addProduct(product => {
				commit('addProduct', product)
			}, data, resolve, reject);
		});
	},

	updateProduct({ commit }, data) {
		return new Promise(function (resolve, reject) {
			products.updateProduct(product => {
				commit('updateProduct', product)
			}, data, resolve, reject);
		});
	},

	deleteProduct({ commit }, data) {
		return new Promise(function (resolve, reject) {
			products.deleteProduct(flag => {
				commit('deleteProduct', {
					data, flag
				})
			}, data, resolve, reject);
		});
	}
};

// mutations
const mutations = {
	setProducts (state, products) {
		state.all = products
	},

	addProduct(state, product) {
		let products = state.all;
		products.push(product);

		state.all = products;
	},

	updateProduct(state, data) {
		let products = state.all;
		let index = _.findIndex(products, {'id': data.id});

		if (index === -1) {
			return;
		}

		let keys = Object.keys(data);

		$.each(keys, (i, key) => {
			if (data[key] && typeof data[key] !== 'undefined') {
				products[index][key] = data[key];
			}
		});

		state.all = products;
	},

	deleteProduct(state, data) {
		if (! data.flag) {
			return;
		}

		let products = state.all;
		let index = _.findIndex(products, {'id': data.data.id});

		if (index === -1) {
			return;
		}

		products.splice(index, 1);

		state.all = products;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
