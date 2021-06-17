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

	addCategory({ commit }, data) {
		return new Promise(function (resolve, reject) {
			categories.addCategory(category => {
				commit('addCategory', category)
			}, data, resolve, reject);
		});
	},

	updateCategory({ commit }, data) {
		return new Promise(function (resolve, reject) {
			categories.updateCategory(category => {
				commit('updateCategory', category)
			}, data, resolve, reject);
		});
	},

	deleteCategory({ commit }, data) {
		return new Promise(function (resolve, reject) {
			categories.deleteCategory(flag => {
				commit('deleteCategory', {
					data, flag
				})
			}, data, resolve, reject);
		});
	}
};

// mutations
const mutations = {
	setCategories (state, categories) {
		state.all = categories
	},

	addCategory(state, category) {
		let categories = state.all;
		categories.push(category);

		state.all = categories;
	},

	updateCategory(state, data) {
		let categories = state.all;
		let index = _.findIndex(categories, {'id': data.id});

		if (index === -1) {
			return;
		}

		categories[index].title = data.title;

		state.all = categories;
	},

	deleteCategory(state, data) {
		if (! data.flag) {
			return;
		}

		let categories = state.all;
		let index = _.findIndex(categories, {'id': data.data.id});

		if (index === -1) {
			return;
		}

		categories.splice(index, 1);

		state.all = categories;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
