<template>
	<div class="min-h-screen">
		<div class="--report">
			<Login :openModal.sync="openModal"/>

			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<PlacesCarousel :places.sync="options.places" :selected.sync="selected"/>

			
		</div>
	</div>
</template>

<script>
	import { Carousel, Slide } from 'vue-carousel';
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Login from "./Users/Login";
	import PlacesCarousel from "./Places/PlacesCarousel";

	export default {
		props: ['options'],
		components: {
			Carousel,
      	Slide,
		    Login,
		    Nav,
		    PlacesCarousel
		},
		data() {
			return {
				openModal: false,
				selected: null
			}
		},

		mounted() {
			if(!!this.options.user) {
				this.openModal = false
			}
		},

		methods : {
			
		},

		watch: {
			selected: function (v) {
				Inertia.get(
          this.$root.route + '/report/view/' + v.id, {},
          {
            onSuccess: () => { },
          },
        );
			}
		}
	}

</script>

<style scoped>
	.--report {
		height: 100vh;
		width: 100vw;
	}

	::-webkit-scrollbar {
	    display: none;
	}
</style>