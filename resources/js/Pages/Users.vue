<template>
	<div class="min-h-screen">
		<div class="--users">
			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full mt-8 ml-10">
				<button class="px-4 py-3 rounded bg-green-400"
					@click="newUser()"
				>
					New
				</button>
			</div>

			<Table class="px-1 md:px-10" :fields="fields" :keys="keys" :list="options.users.data" :title="table.title" 
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
	import Toggle from "../Components/Toggle"; 

	export default {
		props: ['options'],
		components: {
		    Nav,
		    Table,
		    Toggle
		},
		data() {
			return {
				openModal: false,
				fields: ['Name', 'Phone', 'Email', 'User Type', 'Is Active'],
				table: {
					title: 'Users',
					search: this.options.search,
					page: this.options.users.current_page,
					count: this.options.users.last_page,
					selected: null
				},
				keys : [
					{
						label: 'name',
						slot: false,
						slot_name: null
					},

					{
						label: 'phone',
						slot: false,
						slot_name: null
					},

					{
						label: 'email',
						slot: false,
						slot_name: null
					},

					{
						label: 'user_type',
						slot: false,
						slot_name: null
					},

					{
						label: 'is_active',
						slot: true,
						slot_name: 'is_active'
					},
				],
			}
		},

		mounted() {
			if(!!this.options.user) {
				this.openModal = false
			}
		},

		methods: {
			newUser(){
				Inertia.get(
          this.$root.route + '/users/' + 'add', {},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		watch : {
			'table.selected': function (v) {
				Inertia.get(
          this.$root.route + '/users/' + v.id, {},
          {
            onSuccess: () => { },
          },
        );
			},

			'table.page': function (p) {
				Inertia.get(
          this.$root.route + '/users/', {page: p, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			},

			'table.search': function (s) {
				this.table.page = 1

				Inertia.get(
          this.$root.route + '/users/', {page: this.table.page, search: s},
          {
            onSuccess: () => { },
          },
        );
			}
		},
	}

</script>

<style scoped>
	.--users {
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