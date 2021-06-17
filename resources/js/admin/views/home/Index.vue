<template>
	<div class="container pt-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<h5 class="mr-auto card-title">Orders</h5>
				</div><!-- end of div d-flex -->

				<div class="table-responsive" v-if="orders.length > 0">
					<table class="table table-striped">
						<thead>
						<tr>
							<td>#</td>
							<td>Order ID</td>
							<td>Customer Name</td>
							<td>Address</td>
							<td>Status</td>
							<td>Payment Method</td>
							<td>Ordered on</td>
							<td>Action</td>
						</tr>
						</thead>
						<tbody>
						<tr v-for="(order, index) in orders" :key="order.id">
							<td>{{ index + 1 }}</td>
							<td>{{ order.order_id }}</td>
							<td>{{ order.user_name }}</td>
							<td>{{ assembleAddress(order.user_address) }}</td>
							<td>{{ order.status_name }}</td>
							<td>{{ order.payment_method }}</td>
							<td>{{ formatDate(order.created_at) }}</td>
							<td>
								<button type="button" class="btn btn-outline-danger btn-sm"
										@click="deleteConfirmation(order.id)">Delete</button>
							</td>
						</tr>
						</tbody>
					</table>
				</div><!-- end of div table-responsive -->

				<div class="alert alert-danger" role="alert" v-else>
					<h4 class="alert-heading">Sorry!</h4>
					<hr>
					<p class="mb-0">There are no orders to display.</p>
				</div><!-- end of div alert -->
			</div><!-- end of div card-body -->
		</div><!-- end of div card -->
	</div><!-- end of div container -->
</template>

<script>
    export default {
    	computed: {
    		orders() {
    			return this.$store.getters['orders/all'];
			}
		},
		mounted() {
    		this.loadInitialData();
		},
		methods: {
    		loadInitialData() {
    			this.$store.dispatch('orders/getAllOrders')
					.then(response => {
						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.displayErrors(error);
					});
			},
			assembleAddress(address) {
    			address = JSON.parse(address);

    			return `${address.line_1}, ${address.line_2}, ${address.state}, ${address.country} - ${address.post_code}`;
			},
    		formatDate(created) {
    			return moment(created).format('lll');
			},
			deleteConfirmation(id) {
				let order = _.find(this.orders, {'id': id});

				if (typeof order === 'undefined') {
					izitoast.warning({
						title: 'Sorry!',
						message: 'Something went wrong. Try refreshing the page and try again.',
						position: 'topCenter'
					});

					return;
				}

				izitoast.question({
					duration: 2000,
					close: false,
					id: 'question',
					title: 'Attention',
					message: `Do you really want to delete the order ${order.order_id}?`,
					position: 'center',
					buttons: [
						['<button><b>YES</b></button>', (instance, toast) => {
							this.destroy(id, instance, toast);

						}, true],
						['<button>NO</button>', (instance, toast) => {
							instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
						}],
					],
				});
			},
			destroy(id, instance, toast) {
				this.ajax_loading = true;
				this.$store.dispatch('orders/deleteOrder', {
					id: id
				})
					.then(response => {
						this.ajax_loading = false;
						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.ajax_loading = false;

						this.displayErrors(error);
					});
			}
		}
    }
</script>

<style scoped>

</style>
