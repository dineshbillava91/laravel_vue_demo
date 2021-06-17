<template>
	<div>
		<nav-header></nav-header>
		<router-view></router-view>
		<base-footer></base-footer>
	</div>
</template>

<script>
	import NavHeader from './components/NavHeader';
	import BaseFooter from './components/BaseFooter';

	export default {
		components: {NavHeader, BaseFooter},
		mounted() {
			this.loadInitialData();
		},
		methods: {
			loadInitialData() {
				this.$store.dispatch('user/getUser')
					.then(response => {
						//
					})
					.catch(error => {
						//
					});
			}
		}
	}
</script>

<style scoped>

</style>
