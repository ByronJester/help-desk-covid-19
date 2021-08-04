<template>
	<div>
		<Login :openModal.sync="openModal"/>

		<Nav :user.sync="options.user" :openModal.sync="openModal"/>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../../Layouts/Navigation";
	import Login from "../Users/Login";

	export default {
		props: ['options'],
		components: {
		    Login,
		    Nav
		},

		data() {
			return {
				openModal: false,
			}
		},

		mounted() {
			if(!!this.options.user) {
				this.openModal = false
			}

			console.log(this.options)
		},

	}
</script>