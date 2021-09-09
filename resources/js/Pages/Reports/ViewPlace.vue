<template>
	<div class="w-screen">
		<Login :openModal.sync="openModal"/>

		<Nav :user.sync="options.user" :openModal.sync="openModal"/>

		<div v-if="!viewCase && !openModal" class="w-screen">
			<div class="w-full text-lg md:text-4xl md:px-5">
				<i class="fa fa-arrow-left cursor-pointer ml-3" @click="back()"></i> 
				<span class="ml-3">{{options.place.name}} </span>

				<!-- <button 
					class="rounded bg-green-400 border border-green-100 text-white px-1 py-1 md:px-5 md:py-3 float-right md:text-2xl mr-2" 
					@click="newCase()"
				>
				New Case
				</button> -->
			</div>

			<CaseCarousel :cases.sync="options.cases" :selected.sync="selected" :options="options" class="mt-10 px-3 md:px-20"/>

			<ReportsCarousel :records="options.records" class="mt-8 px-3 md:px-20"/>
		</div>

		<CaseModal :viewCase.sync="viewCase" :form.sync="form"/>
		
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../../Layouts/Navigation";
	import Login from "../Users/Login";
	import CaseModal from "../Cases/CaseSave";
	import CaseCarousel from "../Cases/CaseCarousel.vue";
	import ReportsCarousel from "../Reports/ReportsCarousel";

	export default {
		props: ['options'],
		components: {
		    Login,
		    Nav,
		    CaseCarousel,
		    CaseModal,
		    ReportsCarousel,
		},

		data() {
			return {
				openModal: false,
				selected: null,
				viewCase: false,
				form: {
					id: null,
					place_id: null,
					code: null,
					age: null,
					symptom: null,
					gender: 'MALE',
					date: null,
					travel_history: null,
					status: 'RECOVERED'
				}
			}
		},

		mounted() {
			this.selected = null

			this.form = {
				id: null,
				place_id: this.options.place.id,
				code: null,
				age: null,
				symptom: null,
				gender: 'MALE',
				date: null,
				travel_history: null,
				status: 'RECOVERED'
			}

			if(!!this.options.user) {
				this.openModal = false
			}
		},

		methods: {
			newCase() {
				// this.viewCase = true
				
				// this.form = {
				// 	id: null,
				// 	place_id: this.options.place.id,
				// 	code: null,
				// 	age: null,
				// 	symptom: null,
				// 	gender: 'MALE',
				// 	date: null,
				// 	travel_history: null,
				// 	status: 'RECOVERED'
				// }
			},

			back() {
				Inertia.get(
          this.$root.route + '/reports', {},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		watch: {
			selected: function (v) {
				// if(!!v) this.viewCase = true;

				// this.form = {
				// 	id: v.id,
				// 	place_id: v.place_id,
				// 	code: v.code,
				// 	age: v.age,
				// 	symptom: v.symptom,
				// 	gender: v.gender,
				// 	date: v.date,
				// 	travel_history: v.travel_history,
				// 	status: v.status
				// }
			},

			viewCase: function (v) {
				// this.openModal = false
				
				// if(!v) {
				// 	this.selected = null;

				// 	this.form = {
				// 		id: null,
				// 		place_id: this.options.place.id,
				// 		code: null,
				// 		age: null,
				// 		symptom: null,
				// 		gender: 'MALE',
				// 		date: null,
				// 		travel_history: null,
				// 		status: 'RECOVERED'
				// 	}
				// } 
			},

			'options.user': function (v) {
				if(!v) this.viewCase = false
			}
		}

	}
</script>

<style scoped>
	/*p {
		font-family: "Papyrus", "Courier New", cursive;
	}*/
</style>