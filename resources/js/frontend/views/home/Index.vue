<template>
	<div class="container pt-3">
		<div class="d-flex pb-2 mb-2 border-bottom">
			<h5 class="mr-auto card-title">Categories</h5>
			<div>
				<label class="sr-only" for="category">Category</label>
				<select id="category" name="category" class="form-control form-control-sm" v-model="category"
						@change="filterProducts">
					<option value="-1">All</option>
					<option v-for="category in categories" :value="category.id" :key="category.id">
						{{ category.title }}
					</option>
				</select>
			</div>
		</div><!-- end of div d-flex -->


		<div class="row" v-if="products.length > 0">
			<div class="col-md-3 col-sm-4 col-6" v-for="product in products">
				<div class="card mb-2">
					<img :src="product.image" title="product.name" class="card-img-top" alt="">
					<div class="card-body">
						<h5 class="card-title">{{ product.name }}</h5>
						<p class="card-text">{{ product.description }}</p>
						<div class="text-center">
							<div class="input-group mb-3">
								<label class="sr-only" :for="'quantity-' + product.id">Quantity</label>
								<input type="number" :id="'quantity-' + product.id" name="quantity" class="form-control"
									   placeholder="Quantity" value="1">
								<div class="input-group-append">
									<button type="button" class="btn btn-primary" :disabled="ajax_loading"
											@click="addToCart(product.id)">Add to cart</button>
								</div><!-- end of div input-group-append -->
							</div><!-- end of div input-group -->
						</div><!-- end of div text-center -->
					</div><!-- end of div card-body -->
				</div><!-- end of div card -->
			</div><!-- end of div col-md-3 -->
		</div><!-- end of div row -->

		<div class="alert alert-danger" role="alert" v-else>
			<h4 class="alert-heading">Sorry!</h4>
			<hr>
			<p class="mb-0">There are no products to display.</p>
		</div><!-- end of div alert -->
	</div><!-- end of div container -->
</template>

<script>
    export default {
		data() {
			return {
				category: '-1',
				ajax_loading: false,
			}
		},
		computed: {
			categories() {
				return this.$store.getters['categories/all'];
			},
			products() {
				return this.$store.getters['products/all'];
			}
		},
		mounted() {
			this.loadInitialData();
		},
		methods: {
			loadInitialData() {
				this.ajax_loading = true;
				this.$store.dispatch('categories/getCategories')
					.then(response => {
						this.ajax_loading = false;

						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.ajax_loading = false;

						this.displayErrors(error);
					});

				this.$store.dispatch('products/getProducts', {})
					.then(response => {
						this.ajax_loading = false;

						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.ajax_loading = false;

						this.displayErrors(error);
					});
			},
			filterProducts() {
				let data = {};
				if (this.category !== '-1') {
					data = {
						category: this.category,
					};
				}

				this.$store.dispatch('products/getProducts', data)
					.then(response => {
						this.ajax_loading = false;

						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.ajax_loading = false;

						this.displayErrors(error);
					});
			},
			addToCart(id) {
				let quantity = $('#quantity-' + id).val();

				this.ajax_loading = true;

				this.$store.dispatch('carts/addItemToCart', {
					product_id: id,
					quantity: quantity
				})
					.then(response => {
						this.ajax_loading = false;

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
