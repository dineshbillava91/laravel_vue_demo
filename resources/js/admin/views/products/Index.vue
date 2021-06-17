<template>
	<div class="container pt-3 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<h5 class="mr-auto card-title">Products</h5>
					<div>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-product">Add</button>
					</div>
				</div>

				<div class="table-responsive" v-if="all.length > 0">
					<table class="table table-striped table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Image</th>
							<th>Product</th>
							<th>Name</th>
							<th>Description</th>
							<th>Price</th>
							<th class="text-right">Created at</th>
							<th class="text-center">Action</th>
						</tr>
						</thead>
						<tbody>
						<tr v-for="(product, index) in all">
							<td>{{ index + 1}}</td>
							<td>
								<img :src="product.image" title="product.name" alt="" class="img-thumbnail">
							</td>
							<td>{{ product.name }}</td>
							<td>{{ product.category }}</td>
							<td>{{ product.description }}</td>
							<td>{{ product.price }}</td>
							<td class="text-right">{{ formatDate(product.created_at) }}</td>
							<td class="text-center">
								<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-outline-primary" @click="update(product.id)">Update</button>
									<button type="button" class="btn btn-outline-danger"
											@click="deleteConfirmation(product.id)">Delete</button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div><!-- end of div table-responsive -->

				<div class="alert alert-danger" role="alert" v-else>
					<h4 class="alert-heading">Sorry!</h4>
					<hr>
					<p class="mb-0">There are no products to display.</p>
				</div>

			</div><!-- end of div card-body -->
		</div><!-- end of div card -->

		<add-product :categories="categories"></add-product>
		<update-product :categories="categories" :product="update_product"></update-product>
	</div><!-- end of div container -->
</template>

<script>
	import AddProduct from './AddProduct';
	import UpdateProduct from './UpdateProduct';

	export default {
		components: {AddProduct, UpdateProduct},
		data() {
			return {
				update_product: {},
				ajax_loading: false,
			}
		},
		computed: {
			all() {
				return this.$store.getters['products/all'];
			},
			categories() {
				return this.$store.getters['categories/all'];
			}
		},
		mounted() {
			this.loadInitialData();
		},
		methods: {
			loadInitialData() {
				this.ajax_loading = true;
				this.$store.dispatch('products/getProducts')
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
			},
			paginate(page) {
				this.$store.dispatch('products/getProducts', {
					page: page
				})
					.then(response => {
						this.ajax_loading = false;
						window.scrollTo(0, 0);

						if (response.status !== 200 && response.error) {
							this.displaySuccessError(response);
						}
					})
					.catch(error => {
						this.ajax_loading = false;

						this.displayErrors(error);
					});
			},
			formatDate(created) {
				return moment(created).format('LLL');
			},
			update(id) {
				let product = _.find(this.all, {'id': id});

				if (typeof product === 'undefined') {
					return;
				}

				this.update_product = product;
				$("#update-product").modal('show');
			},
			deleteConfirmation(id) {
				let product = _.find(this.all, {'id': id});

				if (typeof product === 'undefined') {
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
					message: `Do you really want to delete the product ${product.name}?`,
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
				this.$store.dispatch('products/deleteProduct', {
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
