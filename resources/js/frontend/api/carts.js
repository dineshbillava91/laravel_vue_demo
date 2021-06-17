export default {
	getCart(cb, resolve, reject) {
		axios.get('/carts/all')
			.then(response => {
				if (response.status === 200 && ! response.error) {
					resolve(response);
					cb(response.data.data);
				} else {
					// TODO: display error
				}
			})
			.catch(error => {
				reject(error);
			});
	},

	addItemToCart(cb, data, resolve, reject) {
		axios.post('/carts/store', data)
			.then(response => {
				if (response.status === 200 && ! response.error) {
					resolve(response);
					cb(response.data.data);
				} else {
					// TODO: display error
				}
			})
			.catch(error => {
				reject(error);
			});
	},

	deleteItem(cb, data, resolve, reject) {
		axios.delete('/carts/destroy/' + data.id)
			.then(response => {
				if (response.status === 200 && ! response.error) {
					resolve(response);

					cb(response.data.data);
				} else {
					// TODO: display error
				}
			})
			.catch(error => {
				reject(error);
			});
	}
}
