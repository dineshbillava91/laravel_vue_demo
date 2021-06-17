export default {
	getUser(cb, resolve, reject) {
		axios.get('/admin/authenticated-user')
			.then(response => {
				resolve(response);

				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				}
			})
			.catch(error => {
				reject(error);
			})
	}
}
