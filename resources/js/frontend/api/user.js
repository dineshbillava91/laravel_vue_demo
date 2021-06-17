export default {
	getUser(cb, resolve, reject) {
		axios.get('authenticated-user')
			.then(response => {
				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				} else {
					// TODO: logout the user
				}
			})
			.catch(error => {
				reject(error);
			})
	},

	getAddress(cb, resolve, reject) {
		axios.get('address')
			.then(response => {
				if (response.status === 200 && ! response.error) {
					cb(response.data.data);
				} else {
					// TODO: logout the user
				}
			})
			.catch(error => {
				reject(error);
			})
	}
}
