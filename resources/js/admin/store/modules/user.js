import user from '../../api/user'

// initial state
const state = {
	user: []
};

// getters
const getters = {
	user: state => state.user,
};

// actions
const actions = {
	getUser ({ commit }) {
		return new Promise(function (resolve, reject) {
			user.getUser(user => {
				commit('setUser', user)
			}, resolve, reject);
		});
	}
};

// mutations
const mutations = {
	setUser (state, user) {
		state.user = user
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
