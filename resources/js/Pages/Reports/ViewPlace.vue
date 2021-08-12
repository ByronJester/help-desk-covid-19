<template>
	<div class="w-screen">
		<Login :openModal.sync="openModal"/>

		<Nav :user.sync="options.user" :openModal.sync="openModal"/>

		<div v-if="!viewCase && !openModal">
			<div class="w-max mb-2 ml-5">
				<div class="bg-green-200 border-t border-b border-green-700 text-black px-4 py-3" role="alert">
				  <p class="text-3xl md:text-7xl">{{ options.place.name }}</p>
				</div>
			</div>

			<div class="w-max ml-5" v-if="isAuthorize('save_case', options.user)">
				<div class="flex items-center bg-blue-500 text-white text-center font-bold px-4 py-3 mt-2" role="alert">
				  <button class="text-sm md:text-xl" @click="newCase()">
				  	<i class="fa fa-plus-square"> </i> <b class="ml-4 uppercase"> New Covid Case</b>
				  </button>
				</div>
			</div>

			<CaseCarousel :cases.sync="options.cases" :selected.sync="selected" :options="options" class="mt-8 md:mt-16"/>

			<ReportsCarousel :records="options.records" class="mt-20"/>
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
				this.viewCase = true
				
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
			}
		},

		watch: {
			selected: function (v) {
				if(!!v) this.viewCase = true;

				this.form = {
					id: v.id,
					place_id: v.place_id,
					code: v.code,
					age: v.age,
					symptom: v.symptom,
					gender: v.gender,
					date: v.date,
					travel_history: v.travel_history,
					status: v.status
				}
			},

			viewCase: function (v) {
				this.openModal = false
				
				if(!v) {
					this.selected = null;

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
				} 
			},

			'options.user': function (v) {
				if(!v) this.viewCase = false
			}
		}

	}
</script>

<style scoped>
	p {
		font-family: "Papyrus", "Courier New", cursive;
	}
</style>