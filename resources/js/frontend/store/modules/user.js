import user from '../../api/user'

// initial state
const state = {
	user: [],
	address: {}
};

// getters
const getters = {
	user: state => state.user,
	address: state => state.address,
};

// actions
const actions = {
	getUser ({ commit }) {
		return new Promise(function (resolve, reject) {
			user.getUser(user => {
				commit('setUser', user)
			}, resolve, reject);
		});
	},

	getAddress ({ commit }) {
		return new Promise(function (resolve, reject) {
			user.getAddress(address => {
				commit('setAddress', address)
			}, resolve, reject);
		});
	}
};

// mutations
const mutations = {
	setUser (state, user) {
		state.user = user
	},

	setAddress (state, address) {
		state.address = address ? address : {};
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
