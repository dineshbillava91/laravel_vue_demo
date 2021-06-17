<template>
	<div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="add-category" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="add-category-title">Add Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div><!-- end of div modal-header -->
				<div class="modal-body">
					<form name="add-category-form" method="post" @submit.prevent="validateBeforeSubmit">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" class="form-control" v-model="title"
								   required maxlength="60">
						</div><!-- end of div form-group -->

						<div class="form-group text-right">
							<button type="submit" class="btn btn-success" title="Add Category" :disabled="ajax_loading">
								<span v-if="ajax_loading">Adding...</span>
								<span v-else>Add Category</span>
							</button>
						</div>
					</form><!-- end of form add-category-form -->
				</div><!-- end of div modal-body -->
			</div><!-- end of div modal-content -->
		</div><!-- end of div modal-dialog -->
	</div><!-- end of div modal -->
</template>

<script>
    export default {
    	data() {
    		return {
    			title: '',
				ajax_loading: false
			}
		},
    	methods: {
			validateBeforeSubmit() {
				if (! this.title.trim()) {
					izitoast.error({
						title: 'Sorry!',
						message: 'Please enter a valid title',
						position: 'topCenter'
					});

					return;
				}

				this.submit();
			},
			submit() {
				this.ajax_loading = true;
				this.$store.dispatch('categories/addCategory', {
					title: this.title
				})
					.then(response => {
						this.title = '';
						this.ajax_loading = false;
						$("#add-category").modal('hide');

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
