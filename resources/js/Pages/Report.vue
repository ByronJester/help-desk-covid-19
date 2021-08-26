<template>
	<div class="min-h-screen">
		<div class="--report"> 
			<Login :openModal.sync="openModal"/>

			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full" v-if="!openModal">
				<select class="border border-green-300 py-2 px-2 mx-2" v-model="filter">
					<option value="1">Reports</option>
				  <option value="2">Brangays</option>
				</select>
			</div>

			<ReportsCarousel :records="options.records" 
				v-if="filter == 1 && !openModal"
				class="px-3 md:px-20"
			/>

			<ReportsCarousel :records="options.records" 
				v-if="filter == 1 && !openModal"
				class="px-3 md:px-20"
			/>

			<ReportsCarousel :records="options.records" 
				v-if="filter == 1 && !openModal"
				class="px-3 md:px-20"
			/>

			<ReportsCarousel :records="options.records" 
				v-if="filter == 1 && !openModal"
				class="px-3 md:px-20"
			/>

			<PlacesCarousel :places.sync="options.places" :selected.sync="selected" 
				v-if="filter == 2 && !openModal" 
				class="px-3 md:px-20"
			/>
			
		</div> 
	</div>

</template>

<script>
	import { Carousel, Slide } from 'vue-carousel';
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Login from "./Users/Login";
	import PlacesCarousel from "./Places/PlacesCarousel";
	import ReportsCarousel from "./Reports/ReportsCarousel";

	export default {
		props: ['options'],
		components: {
			Carousel,
      	Slide,
		    Login,
		    Nav,
		    PlacesCarousel,
		    ReportsCarousel
		},
		data() {
			return {
				openModal: false,
				selected: null,
				filter: 1
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
          this.$root.route + '/reports/view/' + v.id, {},
          {
            onSuccess: () => { },
          },
        );
			},

			filter: function (v) {
				
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