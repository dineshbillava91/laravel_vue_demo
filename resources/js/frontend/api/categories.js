export default {
	getCategories(cb, resolve, reject) {
		axios.get('/categories/all')
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
