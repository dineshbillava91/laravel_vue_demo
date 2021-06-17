<template>
    <div class="container pt-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<h5 class="mr-auto card-title">Categories</h5>
					<div>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-category">Add</button>
					</div>
				</div>

				<div class="table-responsive" v-if="all.length > 0">
					<table class="table table-striped table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th class="text-right">Created at</th>
							<th class="text-center">Action</th>
						</tr>
						</thead>
						<tbody>
						<tr v-for="(category, index) in all">
							<td>{{ index + 1}}</td>
							<td>{{ category.title }}</td>
							<td class="text-right">{{ formatDate(category.created_at) }}</td>
							<td class="text-center">
								<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-outline-primary" @click="update(category.id)">Update</button>
									<button type="button" class="btn btn-outline-danger"
											@click="deleteConfirmation(category.id)">Delete</button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div><!-- end of div table-responsive -->

				<div class="alert alert-danger" role="alert" v-else>
					<h4 class="alert-heading">Sorry!</h4>
					<hr>
					<p class="mb-0">There are no categories to display.</p>
				</div><!-- end of div alert -->
			</div><!-- end of div card-body -->
		</div><!-- end of div card -->

		<add-category></add-category>
		<update-category :category="update_category"></update-category>

	</div><!-- end of div container -->
</template>

<script>
	import AddCategory from './AddCategory';
	import UpdateCategory from './UpdateCategory';

    export default {
    	components: {UpdateCategory, AddCategory},
		data() {
    		return {
				update_category: {},
    			ajax_loading: false,
			}
		},
    	computed: {
    		all() {
    			return this.$store.getters['categories/all'];
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
			},
			formatDate(created) {
    			return moment(created).format('LLL');
			},
			update(id) {
    			let category = _.find(this.all, {'id': id});

    			if (typeof category === 'undefined') {
    				return;
				}

    			this.update_category = category;
    			$("#update-category").modal('show');
			},
			deleteConfirmation(id) {
    			let category = _.find(this.all, {'id': id});

    			if (typeof category === 'undefined') {
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
					message: `Do you really want to delete the category ${category.title}?`,
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
    			this.$store.dispatch('categories/deleteCategory', {
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
