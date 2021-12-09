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

				<!-- <select v-model="form.place_id"
					class="border border-green-500 rounded py-2 md:py-5 px-3 w-3/6 md:w-1/5"
				> 
				  <option v-for="place in options.places" :value="place.id">{{place.name}}</option>
				</select> -->

			</div>

			<Table class="px-1 md:px-10" :fields="fields" :keys="keys" :list="options.vaccinations.data" :title="table.title" 
				:search.sync="table.search" :page.sync="table.page" :count="table.count" :selected.sync="table.selected"
			>
				<template v-slot:actions="{ arg }"> 
					<div class="flex items-center bg-gray-200 text-sm font-bold px-4 py-3 relative" 
						role="alert"
						v-if="!!arg && options.uri == 'vaccinations' && arg.status != 'cancel'"
					>
					  <div class="tex-lg font-bold my-2 w-full">
					  	<span class="absolute text-red-600 cursor-pointer" style="top: -0.4rem; left: -0.3rem" @click="table.selected = null">  
				  			<i class="fa fa-times-circle fa-2x"></i>
					  	</span> 

				  		<span class="text-xs md:text-base ml-10">  
				  			Select Status:
					  	</span> 
				  		<span class="float-right cursor-pointe text-xs md:text-base"
				  		>	
				  			<button class="mx-1 md:mx-3 text-yellow-700" @click="changeStatus(arg.id, 'archive')" 
				  				v-if="!!arg.is_active"
				  			>
				  				Archive 
				  			</button>

				  			<button class="mx-1 md:mx-3 text-yellow-700" @click="changeStatus(arg.id, 'recover')"
				  				v-if="!arg.is_active"
				  			>
				  				Restore 
				  			</button>

				  			<button class="mx-1 md:mx-3" @click="changeStatus(arg.id, 'cancel')" v-if="arg.status != 'finish' && arg.status != 'cancel'">
				  				Cancel 
				  			</button>

				  			<button class="mx-1 md:mx-3" @click="changeStatus(arg.id, 'approve')" v-if="arg.status == 'pending'"> 
				  				Approve 
				  			</button>

				  			<button class="mx-1 md:mx-3" @click="changeStatus(arg.id,'finish')" v-if="arg.status == 'approve'"> 
				  				Finish 
				  			</button>
				  		</span>
				  	</div>
					</div>
				</template>

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
		    Table
		},
		data() {
			return {
				openModal: false,
				fields: ['Name', 'Age', 'Contact', 'Status', 'Date' , 'Active'],
				table: {
					title: 'Vaccinations Approval',
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
						label: 'age',
						slot: false,
						slot_name: null
					},

					// {
					// 	label: 'gender', 
					// 	slot: false,
					// 	slot_name: null
					// },

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

					{
						label: 'date',
						slot: false,
						slot_name: 'date'
					},
					
					{
						label: 'is_active',
						slot: true,
						slot_name: 'is_active'
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
			this.table.search = this.options.search

			consol.log(this.options)
		},

		watch : {
			'table.selected': function (v) {
				// this.$dialog
				//   .confirm('Please confirm to continue')
				//   .then(function(dialog) {
				//     console.log('Clicked on proceed');
				//   })
				//   .catch(function() {
				//     console.log('Clicked on cancel');
				//   });
			},

			'table.page': function (p) {
				Inertia.get(
          this.$root.route + '/' + this.options.uri, {status: this.table.status, place: this.form.place_id, page: p, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			},

			'table.search': function (s) { 
				this.table.page = 1

				Inertia.get(
          this.$root.route + '/' + this.options.uri, {status: this.table.status, place: this.form.place_id, page: this.table.page, search: s},
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
          this.$root.route + '/' + this.options.uri, {status: this.table.status, place: p, page: this.table.page, search: this.table.search},
          {
            onSuccess: () => { },
          },
        );
			}
		},

		methods : {
			changeStatus(id, arg) {
				let data = { id: id, status: arg }

				Inertia.post(
          this.$root.route + '/vaccinations/changeStatus', data,
          {
            onSuccess: () => { 
            	this.table.selected = null
            },
          },
        );

			}
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