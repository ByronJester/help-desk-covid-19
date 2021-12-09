<template>
	<div class="w-screen h-screen">
		<Nav :user.sync="options.auth" :openModal.sync="openModal" />
		<div class="center">
			<p>
				At Online Help Desk Information System For COVID-19, we take privacy seriously and we respect the concerns of our community of users, in this policy we describe our privacy practices with regard to information we collect through help-desk-covid-19. The help-desk-covid-19 helps you to make informed decisions about how you share information when you visit or use the site.
			</p>
		</div>
	</div>
</template>



<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../../Layouts/Navigation";

	export default {
		props: ["options"],
		components: {
		    Nav,
		},
		data() {
			return {
				openModal: false,
			}
		},

		mounted(){

		},

		methods: {

		}
	}
</script>

<style scoped>
	.center {
		text-align: center;
		width: 200px;
	}
</style>