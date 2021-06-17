export default {
	addOrder(cb, data, resolve, reject) {
		axios.post('/orders/store', data)
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
