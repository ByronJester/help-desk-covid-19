<template>
	<div class="w-screen mt-10">
		<div class="flex flex-col">
			<!-- <div class="w-full"> 
				<p :style="{'font-size': labelHeight}"> Select Barangay </p>
			</div> -->

			<div class="w-full">
				<carousel :navigationEnabled="false" :perPage="perPage" :paginationEnabled="pagination">
		      <slide v-for="place in places" :key="place.id" class="w-full cursor-pointer w-full md:px-1">
		          		
		    		<div class="bg-gray-100 flex flex-row" @click="selectPlace(place)">
		    			<div class="w-2/5">
		    				<p class="text-xl md:text-4xl text-center mt-32"> {{ place.name }}</p>
		    			</div>

		    			<div class="w-3/5">
		    				<img
		              :src="'/images/balayan.jpg'"
		              class="w-full"
		              :style="{ 'height': imageHeight }"
		              alt=""
		            />
		    			</div>
		    		</div>
		      </slide>
		    </carousel>
		  </div>
	  </div>
	</div>
</template>

<script>
	export default {
		props: ['places', 'selected'],
		data() {
			return {
				perPage: 1,
				pagination: false,
				imageHeight: '300px',
				labelHeight: '30px'
			}
		},

		mounted() {
			if(window.innerWidth >= 768) {
				this.perPage = 3
				this.pagination = true
				this.imageHeight = '400px'
				this.labelHeight = '40px'
			}
		},

		methods: {
			selectPlace(place) {
				this.$emit('update:selected', place)
			}
		}
	}
</script>

<style>
	::-webkit-scrollbar {
	    display: none;
	}

	/*p {
		font-family: "Papyrus", "Courier New", cursive;
	}*/
</style>