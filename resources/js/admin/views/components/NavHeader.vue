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

					<li class="nav-item">
						<router-link class="nav-link" :to="{ name: 'categories'}">Categories</router-link>
					</li>

					<li class="nav-item">
						<router-link class="nav-link" :to="{ name: 'products'}">Products</router-link>
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
			}
		},
		mounted() {
        	$("#logout-form > input[type=hidden]").val($('meta[name="csrf-token"]').attr('content'));
		},
		methods: {
			logout() {
				$("#logout-form").submit();
			}
		}
    }
</script>

<style scoped>

</style>
