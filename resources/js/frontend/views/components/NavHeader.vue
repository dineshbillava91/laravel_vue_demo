<template>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<router-link class="navbar-brand" :to="{ name: 'home'}">CEX TEST</router-link>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav mr-auto">
				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ml-auto">

					<li class="nav-item dropdown">
						<a id="cartDropdown" class="nav-link dropdown-toggle align-self-center" href="#" role="button"
						   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Cart
							<span class="badge badge-dark ml-1" v-if="cart.length > 0">{{ cart.length }}</span>
							<span class="caret"></span>
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cartDropdown">
							<a class="dropdown-item pr-2 pl-2" href="javascript:void(0)" v-for="item in cart">
								<img :src="item.product_image" :title="item.product_name" alt=""
									 class="mr-2 rounded" style="width: 50px; height: auto">
								{{ item.product_name }} <small class="badge badge-info">{{ item.quantity }}</small>
							</a>
							<div class="dropdown-divider"></div>
							<router-link class="dropdown-item" :to="{ name: 'cart'}">
								View Cart
							</router-link>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
						   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ user.name }} <span class="caret"></span>
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#" @click="logout">Logout</a>

							<form id="logout-form" action="/logout" method="POST" style="display: none;">
								<input type="hidden" name="_token" value="">
							</form>
						</div>
					</li>
				</ul><!-- end of ul navbar-nav -->
			</div><!-- end of div collapse -->
		</div><!-- end of div container -->
	</nav><!-- end of nav navbar -->
</template>

<script>
	export default {
		computed: {
			user() {
				return this.$store.getters['user/user'];
			},
			cart() {
				return this.$store.getters['carts/all'];
			}
		},
		mounted() {
			$("#logout-form > input[type=hidden]").val($('meta[name="csrf-token"]').attr('content'));

			this.loadInitialData();
		},
		methods: {
			loadInitialData() {
				this.$store.dispatch('carts/getCart')
					.then(response => {
						if (response.status !== 200 && response.error) {
							$("#logout-form").submit();
						}
					})
					.catch(error => {
						$("#logout-form").submit();
					});
			},
			logout() {
				$("#logout-form").submit();
			}
		}
	}
</script>

<style scoped>

</style>
