export default {
	getCategories(cb, resolve, reject) {
		axios.get('/admin/categories/all')
			.then(response => {
				resolve(response);

				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				}
			})
			.catch(error => {
				reject(error);
			});
	},

	addCategory(cb, data, resolve, reject) {
		axios.post('/admin/categories/store', data)
			.then(response => {
				resolve(response);

				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				}
			})
			.catch(error => {
				reject(error);
			});
	},

	updateCategory(cb, data, resolve, reject) {
		axios.patch('/admin/categories/update', data)
			.then(response => {
				resolve(response);

				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				}
			})
			.catch(error => {
				reject(error);
			});
	},
	deleteCategory(cb, data, resolve, reject) {
		axios.delete('/admin/categories/destroy/' + data.id)
			.then(response => {
				resolve(response);

				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				}
			})
			.catch(error => {
				reject(error);
			});
	}
}
