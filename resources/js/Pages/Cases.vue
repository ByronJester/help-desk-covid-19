<template>
	<div class="min-h-screen overflow-x-hidden">
		<div class="--cases">
			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full px-1 md:px-10" v-if="!viewCase">
				<button class="bg-green-500 border border-green-500 rounded py-2 md:py-5 px-3 font-bold text-white"
					@click="newCase()"
				>
					NEW CASE
				</button>

				<select v-model="form.place_id"
					class="float-right border border-green-500 rounded py-2 md:py-5 px-3 w-3/6 md:w-1/5"
				>
				  <option v-for="place in options.places" :value="place.id">{{place.name}}</option>
				</select>
			</div>

			<CaseModal :viewCase.sync="viewCase" :form.sync="form" v-if="viewCase"/>

			<Table class="px-1 md:px-10" :fields="fields" :keys="keys" :list="options.cases.data" :title="table.title" 
				:search.sync="table.search" :page.sync="table.page" :count="table.count" :selected.sync="table.selected"
				v-else
			>
				<template v-slot:is_active="{ arg }"> 
					<i class="fa fa-check-square fa-2x text-green-500" v-if="!!arg"></i>
					<i class="fa fa-times-circle fa-2x text-red-500" v-else></i>
				</template>
			</Table>

			
		</div>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Table from "../Components/Table";
	import CaseModal from "./Cases/CaseSave";

	export default {
		props: ['options'],
		components: {
		    Nav,
		    Table,
		    CaseModal
		},
		data() {
			return {
				openModal: false,
				fields: ['Code', 'Age', 'Gender', 'Date', 'Status'],
				table: {
					title: 'Covid 19 Cases',
					search: null,
					page: this.options.cases.current_page,
					count: this.options.cases.last_page,
					selected: null
				},
				keys : [
					{
						label: 'code',
						slot: false,
						slot_name: null
					},

					{
						label: 'age',
						slot: false,
						slot_name: null
					},

					{
						label: 'gender',
						slot: false,
						slot_name: null
					},

					{
						label: 'formatted_date',
						slot: false,
						slot_name: null
					},

					{
						label: 'status',
						slot: false,
						slot_name: null
					},
				],
				viewCase: false,
				form: {
					id: null,
					place_id: this.options.place,
					code: null,
					age: null,
					symptom: null,
					gender: 'MALE',
					date: null,
					travel_history: null,
					status: 'RECOVERED'
				},
			}
		},

		mounted() {

		},

		watch : {
			'table.selected': function (v) {
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

			'table.page': function (p) {
				if(!!this.viewCase) return;

				Inertia.get(
          this.$root.route + '/virus-cases/', {place: this.form.place_id, page: p, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			},

			'table.search': function (s) {
				if(!!this.viewCase) return;
				
				this.table.page = 1

				Inertia.get(
          this.$root.route + '/virus-cases/', {place: this.form.place_id, page: this.table.page, search: s},
          {
            onSuccess: () => { },
          },
        );
			},

			'form.place_id': function (p) {
				if(!!this.viewCase) return;

				Inertia.get(
          this.$root.route + '/virus-cases/', {place: p, page: this.table.page, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		methods : {
			newCase() {
				this.viewCase = true
				
				this.form = {
					id: null,
					place_id: this.form.place_id,
					code: null,
					age: null,
					symptom: null,
					gender: 'MALE',
					date: null,
					travel_history: null,
					status: 'RECOVERED'
				}
			}
		}
	}

</script>

<style scoped>
	.--cases {
		height: 100vh;
		width: 100vw;
	}

	::-webkit-scrollbar {
	    display: none;
	}

	/* CHECKBOX TOGGLE SWITCH */
  /* @apply rules for documentation, these do not work as inline style */
  .toggle-checkbox:checked {
    @apply: right-0 border-green-400;
    right: 0;
    border-color: #68d391;
  }
  .toggle-checkbox:checked + .toggle-label {
    @apply: bg-green-400;
    background-color: #68d391;
  }
</style>