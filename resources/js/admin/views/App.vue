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
						if (response.status !== 200 && response.error) {
							$("#logout-form").submit();
						}
					})
					.catch(error => {
						$("#logout-form").submit();
					});
			}
		}
    }
</script>

<style scoped>

</style>
