<template>
	<div class="min-h-screen">
		<div class="--home">
			<Login :openModal.sync="openModal"/>

			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			Home
		</div>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Login from "./Users/Login";

	export default {
		props: ['options'],
		components: {
		    Login,
		    Nav
		},
		data() {
			return {
				openModal: false
			}
		},

		mounted() {
			if(!!this.options.user) {
				this.openModal = false
			}
		},

		methods : {
			
		}
	}

</script>

<style scoped>
	.--home {
		height: 100vh;
		width: 100vw;
	}

	::-webkit-scrollbar {
	    display: none;
	}
</style>