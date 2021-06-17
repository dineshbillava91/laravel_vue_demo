import orders from '../../api/orders'

// initial state
const state = {
	all: []
};

// getters
const getters = {
	//
};

// actions
const actions = {
	addOrder ({ commit }, data) {
		return new Promise(function (resolve, reject) {
			orders.addOrder(order => {
				commit('addOrder', order)
			}, data, resolve, reject);
		});
	},
};

// mutations
const mutations = {
	addOrder (state, order) {
		//
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
