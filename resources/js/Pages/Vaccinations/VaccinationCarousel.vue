<template>
	<div class="w-screen">
		<div class="flex flex-col">
			<div class="w-full">
				<carousel :navigationEnabled="false" :perPage="perPage" :paginationEnabled="pagination" v-if="vaccinations.length > 0">
		      <slide v-for="vaccination in vaccinations" :key="vaccination.id" 
		      	class="w-full w-full mr-1 bg-blue-100"
		      >
		    		<div class="text-center mx-3 my-3">
		    			<p class="font-bold md:text-xl">
		    				{{ vaccination.name}}
		    			</p>

		    			<p class="font-bold md:text-xl">
		    				{{ vaccination.age}} y/o
		    			</p>

		    			<p class="font-bold md:text-xl">
		    				{{ vaccination.classification}} priority
		    			</p>

		    			<p class="font-bold md:text-xl">
		    				{{ vaccination.vaccine_name }} vaccine
		    			</p>

		    		</div>
		      </slide>
		    </carousel>

		    <carousel :navigationEnabled="false" :perPage="perPage" :paginationEnabled="pagination" v-else>
		      <slide class="w-full cursor-pointer w-full px-1" @s>
		    		<div class="bg-blue-300 text-center h-60 text-white" style="background-image: url('/images/cases_bg.jpg'); background-repeat: no-repeat; background-size: cover;">
		    			<p style="font-size: 25px" class="pt-24"> NO VACCINATION LIST FOUND</p>
		    		</div>
		      </slide>
		    </carousel>
		  </div>
	  </div>
	</div>
</template>

<script>
	export default {
		props: ['vaccinations'],
		data() {
			return {
				perPage: 1,
				pagination: false
			}
		},

		mounted() {
			if(window.innerWidth >= 768) {
				this.perPage = 5
				this.pagination = false
			}
		},

		methods: {

		}
	}
</script>

<style scoped>
	::-webkit-scrollbar {
	    display: none;
	}
</style>