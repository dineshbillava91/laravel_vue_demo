export default {
	getProducts(cb, resolve, reject) {
		axios.get('/admin/products/all')
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

	addProduct(cb, data, resolve, reject) {
		axios.post('/admin/products/store', data)
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

	updateProduct(cb, data, resolve, reject) {
		axios.patch('/admin/products/update', data)
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
	deleteProduct(cb, data, resolve, reject) {
		axios.delete('/admin/products/destroy/' + data.id)
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
