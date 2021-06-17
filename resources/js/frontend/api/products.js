export default {
	getProducts(cb, data, resolve, reject) {
		let url = '/products/all';

		if (Object.keys(data).length > 0) {
			$.each(data, (field, value) => {
				url += `?${field}=${value}`;
			});
		}

		axios.get(url)
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
}
