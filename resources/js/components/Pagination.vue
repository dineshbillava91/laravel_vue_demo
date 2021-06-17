<template>
	<nav class="d-flex justify-content-end" aria-label="pagination"
		 v-if="data.hasOwnProperty('last_page') && data.last_page > 1">
		<ul class="pagination">
			<li class="page-item" :class="{'disabled': data.current_page === 1}">
				<a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true"
				   @click="changePage(generatePaginator.current_page - 1)">Previous</a>
			</li>
			<li class="page-item" v-for="page in generatePaginator.range" @click="changePage(page)" :key="page"
				:class="[generatePaginator.current_page === page ? 'active' : '']">
				<a class="page-link" href="javascript:void(0)">
					{{ page }}
				</a>
			</li>
			<li class="page-item" :class="{'disabled': data.last_page === data.current_page}">
				<a class="page-link" href="javascript:void(0)" @click="changePage(generatePaginator.current_page + 1)">Next</a>
			</li>
		</ul>
	</nav>
</template>

<script>
	export default {
		props: ['data'],
		computed: {
			generatePaginator() {
				if (! this.data.hasOwnProperty('current_page') && ! this.data.hasOwnProperty('from')
					&& ! this.data.hasOwnProperty('last_page')) {
					return {};
				}

				let current_page = this.data.current_page;
				let min_page_range = current_page - 2 < 1 ? 1 : current_page - 2;
				let max_page_range = current_page + 2 > this.data.last_page ? this.data.last_page : current_page + 2;

				return {
					current_page: this.data.current_page,
					range: _.range(min_page_range, max_page_range + 1)
				}
			}
		},
		methods: {
			changePage(page) {
				if (page < 1 || page > this.data.total) {
					izitoast.info({
						title: 'Sorry!',
						message: 'There is not more data to load!'
					});

					return;

				}
				this.$emit('pagination-change-page', page);
			}
		}
	}
</script>
