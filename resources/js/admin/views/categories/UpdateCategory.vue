<template>
	<div class="modal fade" id="update-category" tabindex="-1" role="dialog" aria-labelledby="update-category" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="update-category-title">Update Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div><!-- end of div modal-header -->
				<div class="modal-body">
					<form name="update-category-form" method="post" @submit.prevent="validateBeforeSubmit">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" class="form-control" v-model="title"
								   required maxlength="60">
						</div><!-- end of div form-group -->

						<div class="form-group text-right">
							<button type="submit" class="btn btn-success" title="Update Category" :disabled="ajax_loading">
								<span v-if="ajax_loading">Updating...</span>
								<span v-else>Update Category</span>
							</button>
						</div>
					</form><!-- end of form update-category-form -->
				</div><!-- end of div modal-body -->
			</div><!-- end of div modal-content -->
		</div><!-- end of div modal-dialog -->
	</div><!-- end of div modal -->
</template>

<script>
    export default {
    	props: ['category'],
		data() {
			return {
				id: '',
				title: '',
				ajax_loading: false
			}
		},
		watch: {
			category: function (new_category) {
				this.id = new_category.id;
				this.title = new_category.title;
			}
		},
		methods: {
			validateBeforeSubmit() {
				this.submit();
			},
			submit() {
				this.ajax_loading = true;
				this.$store.dispatch('categories/updateCategory', {
					id: this.id,
					title: this.title
				})
					.then(response => {
						this.ajax_loading = false;
						$("#update-category").modal('hide');

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
