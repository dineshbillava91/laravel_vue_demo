export default {
	getOrders(cb, resolve, reject) {
		axios.get('/admin/orders/all')
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

	deleteOrder(cb, data, resolve, reject) {
		axios.delete('/admin/orders/destroy/' + data.id)
			.then(response => {
				resolve(response);

				if (response.status === 200 && !response.error) {
					cb(response.data.data);
				}
			})
			.catch(error => {
				reject(error);
			});
	}
}
