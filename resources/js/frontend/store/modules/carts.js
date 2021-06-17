import carts from '../../api/carts'

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
	getCart ({ commit }) {
		return new Promise(function (resolve, reject) {
			carts.getCart(cart => {
				commit('setCart', cart)
			}, resolve, reject);
		});
	},

	addItemToCart({ commit }, data) {
		return new Promise(function (resolve, reject) {
			carts.addItemToCart(cart => {
				commit('addItemToCart', cart)
			}, data, resolve, reject);
		});
	},

	deleteItem({ commit }, data) {
		return new Promise(function (resolve, reject) {
			carts.deleteItem(flag => {
				commit('deleteItem', {
					data, flag
				})
			}, data, resolve, reject);
		});
	}
};

// mutations
const mutations = {
	setCart (state, cart) {
		state.all = cart
	},

	addItemToCart(state, item) {
		let cart = state.all;

		let index = _.findIndex(cart, {'id': item.id});

		if (index === -1) {
			cart.push(item);
		} else {
			cart[index].quantity = item.quantity;
		}

		state.all = cart;
	},
	deleteItem(state, data) {
		if (! data.flag) {
			return;
		}

		let cart = state.all;
		let index = _.findIndex(cart, {'id': data.data.id});

		if (index === -1) {
			return;
		}

		cart.splice(index, 1);

		state.all = cart;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
