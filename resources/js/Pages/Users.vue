<template>
	<div class="min-h-screen">
		<div class="--users">
			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<Table :fields="fields" :keys="keys" :list="options.users" :title="'LGU Accounts'" :selected.sync="selected" class="px-10">
				<template v-slot:is_active="{ arg }"> 
					<!-- <Toggle v-model="arg"/> -->
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
				selected: null,
				aaa: true
			}
		},

		mounted() {
			if(!!this.options.user) {
				this.openModal = false
			}
		},

		watch : {
			selected: function (v) {
				Inertia.get(
          this.$root.route + '/users/' + v.id, {},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		methods : {
			
		}
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