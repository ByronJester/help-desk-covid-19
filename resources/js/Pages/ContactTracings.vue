<template>
	<div class="min-h-screen overflow-x-hidden">
		<div class="--tracing">
			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full px-1 md:px-10">
				<button class="bg-green-500 border border-green-500 rounded py-2 md:py-5 px-4 font-bold text-white"
					@click="newTracing"
				>
					New
				</button>

				<select v-model="form.place_id"
					class="float-right border border-green-500 rounded py-2 md:py-5 px-3 w-3/6 md:w-1/5"
				>
				  <option v-for="place in options.places" :value="place.id">{{place.name}}</option>
				</select>
			</div>

			<Table class="px-1 md:px-10" :fields="fields" :keys="keys" :list="options.tracings.data" :title="table.title" 
				:search.sync="table.search" :page.sync="table.page" :count="table.count" :selected.sync="table.selected"
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

	export default {
		props: ['options'],
		components: {
		    Nav,
		    Table,
		},
		data() {
			return {
				openModal: false,
				fields: ['Name', 'Birth Date', 'Gender', 'Contact', 'Active'],
				table: {
					title: 'Covid 19 Contact Tracing',
					search: this.options.search,
					page: this.options.tracings.current_page,
					count: this.options.tracings.last_page,
					selected: null
				},
				keys : [
					{
						label: 'name',
						slot: false,
						slot_name: null
					},

					{
						label: 'formatted_date',
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
						label: 'is_active',
						slot: true,
						slot_name: 'is_active'
					},
				],
				form: {
					place_id: this.options.place
				}
			}
		},

		methods: {
			newTracing() {
				Inertia.get(
          this.$root.route + '/contact-tracing/add', {place: this.form.place_id},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		watch : {
			'table.selected': function (v) {
				Inertia.get(
          this.$root.route + '/contact-tracing/' + v.id, {place: this.form.place_id},
          {
            onSuccess: () => { },
          },
        );
			},

			'table.page': function (p) {
				Inertia.get(
          this.$root.route + '/contact-tracing/', {place: this.form.place_id, page: p, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			},

			'table.search': function (s) {
				this.table.page = 1

				Inertia.get(
          this.$root.route + '/contact-tracing/', {place: this.form.place_id, page: this.table.page, search: s},
          {
            onSuccess: (res) => { 
            	this.table.search = res.props.options.search
            },
          },
        );
			},

			'form.place_id': function (p) {
				Inertia.get(
          this.$root.route + '/contact-tracing/', {place: p, page: this.table.page, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			}
		},
	}
</script>

<style scoped>
	.--tracing {
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