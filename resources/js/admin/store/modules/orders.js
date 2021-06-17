import orders from '../../api/orders';

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
	getAllOrders ({ commit }) {
		return new Promise(function (resolve, reject) {
			orders.getOrders(products => {
				commit('setOrders', products)
			}, resolve, reject);
		});
	},

	deleteOrder({ commit }, data) {
		return new Promise(function (resolve, reject) {
			orders.deleteOrder(flag => {
				commit('deleteOrder', {
					data, flag
				})
			}, data, resolve, reject);
		});
	}
};

// mutations
const mutations = {
	setOrders (state, orders) {
		state.all = orders
	},

	deleteOrder(state, data) {
		if (! data.flag) {
			return;
		}

		let orders = state.all;
		let index = _.findIndex(orders, {'id': data.data.id});

		if (index === -1) {
			return;
		}

		orders.splice(index, 1);

		state.all = orders;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
