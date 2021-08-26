<template>
	<div class="w-screen">
		<div class="--home">
			<Login :openModal.sync="openModal"/>

			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="flex flex-col mt-10 mb-5 items-center" v-if="!openModal">
			  <div class="w-4/5 md:w-2/5 bg-gray-300 rounded">

			  	<div class="mx-5 my-5">
				  	<label class="text-xs md:text-lg uppercase font-bold"> What's new announcement ? </label><br><br>
				  	<textarea rows="4" class="rounded px-2 py-2 border border-green-500 w-full">
						</textarea>
					</div>

					<div class="mx-5 my-2">
				  	<carousel :navigationEnabled="false" :perPage="1" :paginationEnabled="true">
				      <slide class="w-full bg-red-200" style="height: 250px">
				    		AAAAA
				      </slide>
				    </carousel>
					</div>

					<div class="mx-5 mb-5 mt-5">
				  	<button class="rounded bg-blue-700 py-4 font-bold text-xs md:text-lg w-full uppercase text-white">
				  		Post
				  	</button>
					</div>

			  </div>

				<div class="w-4/5 md:w-2/5 bg-gray-200 my-5 rounded">
			  	
			  </div>

			</div>
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

	textarea {
    overflow: auto;
    outline: none;

    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;

    resize: none; /*remove the resize handle on the bottom right*/
	}
</style>