export default {
	methods: {
		displayErrors(error) {
			if (error.hasOwnProperty('response')) {
				switch (error.response.status) {
					case 422:
						$.each(error.response.data.errors, (field, message) => {
							izitoast.error({
								title: 'Sorry!',
								message: message,
								position: 'topCenter'
							});
						});

						return;
					case 500:
						izitoast.error({
							title: 'Sorry!',
							message: 'Looks like something went wrong on the server side. Please contact the administrator.',
							position: 'topCenter'
						});

						return;
					case 403:
						izitoast.error({
							title: 'Sorry!',
							message: 'You not have permission to access the data.'
						});

						return;
					case 405:
						izitoast.error({
							title: 'Sorry!',
							message: 'Method is not allowed. Please contact the administrator.',
							position: 'topCenter'
						});

						return;
					default:
						return;
				}
			} else {
				izitoast.error({
					title: 'Sorry!',
					message: 'Looks like something went wrong. Please contact the administrator.',
					position: 'topCenter'
				});
			}
		},
		displaySuccessError(response) {
			if (response.data.hasOwnProperty('message')) {
				izitoast.error({
					title: 'Sorry!',
					message: response.data.message
				});
			} else {
				izitoast.error({
					'title': 'Sorry!',
					message: 'Something went wrong on the server side. Please try later.'
				});
			}
		},
		formatNumber(number) {
			if (isNaN(number) || number === null) {
				return 0;
			}

			number              = number.toString();
			let lastThree       = number.substring(number.length - 3);
			let otherNumbers    = number.substring(0, number.length - 3);

			if(otherNumbers !== '') {
				lastThree = ',' + lastThree;
			}

			return otherNumbers.replace(/\B(?=(\d{3})+(?!\d))/g, ",") + lastThree;
		}
	},
};
