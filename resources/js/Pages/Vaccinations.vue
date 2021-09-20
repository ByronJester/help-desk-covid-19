<template>
	<div class="min-h-screen overflow-x-hidden">
		<div class="--vaccinations">
			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full px-1 md:px-10">
				<!-- <button class="bg-green-500 border border-green-500 rounded py-2 md:py-5 px-3 font-bold text-white uppercase"
					@click="newCase()"
				>
					new vaccination
				</button> -->

				<select v-model="form.place_id"
					class="border border-green-500 rounded py-2 md:py-5 px-3 w-3/6 md:w-1/5"
				>
				  <option v-for="place in options.places" :value="place.id">{{place.name}}</option>
				</select>

			</div>

			<Table class="px-1 md:px-10" :fields="fields" :keys="keys" :list="options.vaccinations.data" :title="table.title" 
				:search.sync="table.search" :page.sync="table.page" :count="table.count" :selected.sync="table.selected"
			>
			</Table>
		</div>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Table from "../Components/Table";

	export default {
		props: ['options'],
		components: {
		    Nav,
		    Table
		},
		data() {
			return {
				openModal: false,
				fields: ['Name', 'Vaccine', 'Age', 'Gender', 'Contact', 'Status'],
				table: {
					title: 'Vaccinations',
					search: this.options.search,
					page: this.options.vaccinations.current_page,
					count: this.options.vaccinations.last_page,
					selected: null
				},
				keys : [
					{
						label: 'name',
						slot: false,
						slot_name: null
					},

					{
						label: 'vaccine_name',
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
						label: 'phone',
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
			// this.table.search = this.options.search
		},

		watch : {
			'table.selected': function (v) {
				
			},

			'table.page': function (p) {
				Inertia.get(
          this.$root.route + '/vaccinations', {place: this.form.place_id, page: p, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			},

			'options.search': function (s) { 
				this.table.page = 1

				Inertia.get(
          this.$root.route + '/vaccinations', {place: this.form.place_id, page: this.table.page, search: s},
          {
            onSuccess: (res) => { 
            	this.table.search = res.props.options.search
            },
          },
        );
			},

			'form.place_id': function (p) {
				if(!!this.viewCase) return;

				Inertia.get(
          this.$root.route + '/vaccinations/', {place: p, page: this.table.page, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		methods : {
			// newCase() {
			// 	this.viewCase = true
				
			// 	this.form = {
			// 		id: null,
			// 		place_id: this.form.place_id,
			// 		code: null,
			// 		age: null,
			// 		symptom: null,
			// 		gender: 'MALE',
			// 		date: null,
			// 		travel_history: null,
			// 		status: 'RECOVERED'
			// 	}
			// }
		}
	}

</script>

<style scoped>
	.--vaccinations {
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