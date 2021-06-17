import categories from '../../api/categories'

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
	getCategories ({ commit }) {
		return new Promise(function (resolve, reject) {
			categories.getCategories(categories => {
				commit('setCategories', categories)
			}, resolve, reject);
		});
	},
};

// mutations
const mutations = {
	setCategories (state, categories) {
		state.all = categories
	},
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
