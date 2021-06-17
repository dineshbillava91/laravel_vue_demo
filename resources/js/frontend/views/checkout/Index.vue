<template>
	<div class="container">
		<div class="py-5 text-center">
			<h2>Checkout</h2>
		</div><!-- end of div py-5 -->

		<div class="row">
			<div class="col-md-4 order-md-2 mb-4">
				<h4 class="d-flex justify-content-between align-items-center mb-3">
					<span class="text-muted">Your cart</span>
					<span class="badge badge-secondary badge-pill">{{ cart.length }}</span>
				</h4>
				<ul class="list-group mb-3">
					<li class="list-group-item d-flex justify-content-between lh-condensed" v-for="item in cart" :key="item.id">
						<div>
							<h6 class="my-0">Product name</h6>
							<small class="text-muted">
								{{ item.product_name }}
								<span class="badge badge-secondary badge-pill">{{ item.quantity }}</span>
							</small>
						</div>
						<span class="text-muted">{{ item.product_price }}</span>
					</li>

					<li class="list-group-item d-flex justify-content-between">
						<span>Total (USD)</span>
						<strong>{{ totalPrice }}</strong>
					</li>
				</ul>
			</div><!-- end of div col-md-4 -->

			<div class="col-md-8 order-md-1">
				<h4 class="mb-3">Billing address</h4>
				<form name="billing-address-form" method="post" @submit.prevent="validateBeforeSubmit">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="firstName">First name</label>
							<input type="text" class="form-control" id="firstName" name="First Name" v-model="address.first_name" required>
						</div><!-- end of div col-md-6 -->
						<div class="col-md-6 mb-3">
							<label for="lastName">Last name</label>
							<input type="text" class="form-control" id="lastName" v-model="address.last_name" required>
						</div><!-- end of div col-md-6 -->
					</div><!-- end of div row -->

					<div class="mb-3">
						<label for="address">Address</label>
						<input type="text" class="form-control" id="address" placeholder="1234 Main St"
							   v-model="address.line_1" required>
					</div>

					<div class="mb-3">
						<label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
						<input type="text" class="form-control" id="address2" placeholder="Apartment or suite" v-model="address.line_2">
					</div>

					<div class="row">
						<div class="col-md-5 mb-3">
							<label for="country">Country</label>
							<input type="text" class="form-control" id="country" placeholder="India" v-model="address.country">
						</div>
						<div class="col-md-4 mb-3">
							<label for="state">State</label>
							<input type="text" class="form-control" id="state" placeholder="Maharashtra" v-model="address.state">
						</div>
						<div class="col-md-3 mb-3">
							<label for="zip">Zip</label>
							<input type="text" class="form-control" id="zip" v-model="address.post_code" required>
						</div>
					</div>

					<hr class="mb-4">

					<h4 class="mb-3">Payment</h4>

					<div class="d-block my-3">
						<div class="custom-control custom-radio">
							<input id="cod" name="paymentMethod" type="radio" class="custom-control-input" checked required>
							<label class="custom-control-label" for="cod">Cash on Delivery</label>
						</div>
					</div>

					<hr class="mb-4">
					<button class="btn btn-primary btn-lg btn-block" type="submit" :disabled="ajax_loading">Place an Order</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
    	data() {
    		return {
    			address: {
    				first_name: '',
					last_name: '',
    				line_1: '',
					line_2: '',
					city: '',
					state: '',
					country: '',
					post_code: ''
				},
				ajax_loading: false,
			}
		},
		computed: {
			cart() {
				return this.$store.getters['carts/all'];
			},
			userAddress() {
				return this.$store.getters['user/address'];
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
		watch: {
			userAddress(new_address) {
				if (Object.keys(new_address).length === 0) {
					return;
				}

				this.address = new_address;
			}
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

				this.$store.dispatch('user/getAddress')
					.then(response => {
						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.displayErrors(error);
					});
			},
			validateBeforeSubmit() {
				this.submit();
			},
			submit() {
				this.ajax_loading = true;

				this.$store.dispatch('orders/addOrder', {
					address: this.address,
					cart: this.cart,
					payment_method_id: 1,
				})
					.then(response => {
						this.ajax_loading = false;
						izitoast.success({
							title: 'Great!',
							message: 'We have successfully placed your order. Redirecting back...',
							position: 'topCenter',
							onClosed: function () {
								window.location = '/home';
							}
						});

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
