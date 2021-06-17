<template>
	<div class="container pt-3">
		<div class="d-flex pb-2 mb-2 border-bottom">
			<h5 class="mr-auto card-title">Cart</h5>
		</div><!-- end of div d-flex -->

		<div v-if="cart.length > 0">
			<div class="table-responsive border-bottom">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>#</th>
						<th>Product</th>
						<th class="text-right">Quantity</th>
						<th class="text-right">Price</th>
						<th class="text-right">Total</th>
						<th class="text-center">Action</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="(item, index) in cart" :key="item.id">
						<td>{{ index + 1 }}</td>
						<td>
							<img :src="item.product_image" title="item.product_name" alt="" class="rounded">
							{{ item.product_name }}
						</td>
						<td class="text-right">{{ item.quantity }}</td>
						<td class="text-right">{{ item.product_price }}</td>
						<td class="text-right">{{ item.product_price * item.quantity }}</td>
						<td class="text-center">
							<button type="button" class="btn btn-outline-danger btn-sm"
									@click="deleteConfirmation(item.id)">Delete</button>
						</td>
					</tr>
					</tbody>
				</table>
			</div><!-- end of div table-responsive -->

			<div class="row">
				<div class="col-md-4 col-sm-6 col-12 offset-md-8 offset-sm-6">
					<div class="table-responsive mt-3">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td class="text-uppercase font-weight-bold">Total Items</td>
								<td class="text-right">{{ totalItems }}</td>
							</tr>
							<tr>
								<td class="text-uppercase font-weight-bold">Total Price</td>
								<td class="text-right">{{ totalPrice }}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="text-right mb-3">
				<router-link class="btn btn-primary" :to="{ name: 'checkout'}">Checkout</router-link>
			</div><!-- end of div text-right -->
		</div>

		<div class="alert alert-danger" role="alert" v-else>
			<h4 class="alert-heading">Sorry!</h4>
			<hr>
			<p class="mb-0">There are no products in your cart.</p>
		</div><!-- end of div alert -->
	</div><!-- end of div container -->
</template>

<script>
    export default {
		computed: {
			cart() {
				return this.$store.getters['carts/all'];
			},
			totalItems() {
				let cart = this.$store.getters['carts/all'];
				let total = 0;

				$.each(cart, (index, item) => {
					total += item.quantity;
				});

				return total;
			},
			totalPrice() {
				let cart = this.$store.getters['carts/all'];
				let total = 0;

				$.each(cart, (index, item) => {
					total += item.product_price;
				});

				return total;
			}
		},
		mounted() {
			this.loadInitialData();
		},
		methods: {
			loadInitialData() {
				this.$store.dispatch('carts/getCart')
					.then(response => {
						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.displayErrors(error);
					});
			},
			deleteConfirmation(id) {
				let item = _.find(this.cart, {'id': id});

				if (typeof item === 'undefined') {
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
					message: `Do you really want to delete the category ${item.product_name}?`,
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
				this.$store.dispatch('carts/deleteItem', {
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
	img {
		max-width: 100px;
		height: auto;
	}
</style>
