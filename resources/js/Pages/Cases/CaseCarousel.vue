<template>
	<div class="w-screen">
		<div class="flex flex-col">
			<div class="w-full">
				<carousel :navigationEnabled="false" :perPage="perPage" :paginationEnabled="pagination" v-if="cases.length > 0">
		      <slide v-for="c in cases" :key="c.id" class="w-full w-full md:px-1">
		    		<div @click="isAuthorize('save_case', options.user) ? selectCase(c) : ''" 
		    			class="bg-blue-200 text-left text-white py-2 px-2 text-2xl pt-5 text-center" 
		    			style="background-image: url('/images/cases_bg.jpg');
		    			 background-repeat: no-repeat; background-size: cover; height: 370px;">
		    			<div>
		    				<span> Patient Code: {{ c.code }}</span>
		    			</div>

		    			<div>
		    				<span>Age: {{ c.age }} y/o</span>
		    			</div>

		    			<div>
		    				<span> Gender: {{ c.gender }}</span>
		    			</div>

		    			<div>
		    				<span> Status: {{ c.status }}</span>
		    			</div>

		    			<div v-if="c.status == 'RECOVERED' && c.recovered">
		    				<span> Recovered Date: <br>{{ c.recovered }}</span>
		    			</div>

		    			<div v-if="c.status == 'DEATH' && c.death">
		    				<span> Death Date: <br>{{ c.death }}</span>
		    			</div>

		    			<div v-if="c.status == 'QUARANTINE' && c.quarantine">
		    				<span> Quarantine Date: <br>{{ c.quarantine }}</span>
		    			</div>

		    			<div>
		    				<span> Date Tested: <br>{{ c.formatted_date }}</span>
		    			</div>

		    			<div v-if="c.symptom">
		    				<span> {{  c.symptom.charAt(0).toUpperCase() + c.symptom.slice(1) }}</span>
		    			</div>

		    			<div v-if="c.travel_history">
		    				<span> Travel History: <br>{{ c.travel_history }}</span>
		    			</div>
		    			
		    		</div>
		      </slide>
		    </carousel>

		    <carousel :navigationEnabled="false" :perPage="perPage" :paginationEnabled="pagination" v-else>
		      <slide class="w-full cursor-pointer w-full px-1" @s>
		    		<div class="bg-blue-300 text-center h-60 text-white" style="background-image: url('/images/cases_bg.jpg'); background-repeat: no-repeat; background-size: cover;">
		    			<p style="font-size: 25px" class="pt-24"> NO COVID CASE FOUND</p>
		    		</div>
		      </slide>
		    </carousel>
		  </div>
	  </div>
	</div>
</template>

<script>
	export default {
		props: ['cases', 'selected', "options"],
		data() {
			return {
				perPage: 1,
				pagination: false
			}
		},

		mounted() {
			if(window.innerWidth >= 768) {
				this.perPage = 3
				this.pagination = true
			}
		},

		methods: {
			selectCase(arg) {
				this.$emit('update:selected', arg)
			}
		}
	}
</script>

<style scoped>
	::-webkit-scrollbar {
	    display: none;
	}
</style>