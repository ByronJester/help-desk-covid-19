<template>
	<div class="w-screen h-screen">
		<Nav :user.sync="options.auth" :openModal.sync="openModal" />
		<div class="w-full text-lg md:text-4xl md:px-10">
			<i class="fa fa-arrow-left cursor-pointer ml-3 md:ml-10" @click="back()"></i> 
			 <span class="ml-3">{{options.user ? options.user.name : 'New User'}} </span>

			<button 
				class="rounded bg-green-400 border border-green-100 text-white px-1 py-1 md:px-5 md:py-3 float-right md:text-2xl mr-2" 
				@click="save()"
			>
				Save
			</button>
		</div>

		<div class="w-full flex flex-col mt-20 md:px-32">
			<div class="w-full flex-col md:flex-row">
				<div class="w-full px-2 md:px-3 inline-flex">
					<label class="font-bold"> {{ !!user.is_active ? 'Verified' : 'Unverified' }} </label>
					<Toggle v-model="user.is_active"  class="ml-5"/>
				</div>
			</div>
			<div class="w-full flex flex-col md:flex-row py-3 md:py-20">
				<div class="w-full px-2 md:px-3">
					<label class="font-bold"><b class="text-red-500">*</b> First Name</label><br><br>
					<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="user.first_name">
					<span class="text-sm text-red-500">{{validationError('first_name', saveError)}} </span>
				</div>

				<div class="w-full px-2 md:px-3">
					<label class="font-bold"> Middle Name</label><br><br>
					<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="user.middle_name">
					<span class="text-sm text-red-500">{{validationError('middle_name', saveError)}} </span>
				</div>

				<div class="w-full px-2 md:px-3">
					<label class="font-bold"><b class="text-red-500">*</b> Last Name</label><br><br>
					<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="user.last_name">
					<span class="text-sm text-red-500">{{validationError('last_name', saveError)}} </span>
				</div>
			</div>

			<div class="w-full flex flex-col md:flex-row py-3 md:py-20">
				<div class="w-full px-2 md:px-3">
					<label class="font-bold"><b class="text-red-500">*</b> Email</label><br><br>
					<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="user.email">
					<span class="text-sm text-red-500">{{validationError('email', saveError)}} </span>
				</div>

				<div class="w-full px-2 md:px-3">
					<label class="font-bold"><b class="text-red-500">*</b> Phone</label><br><br>
					<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="user.phone">
					<span class="text-sm text-red-500">{{validationError('phone', saveError)}} </span>
				</div>

				<div class="w-full px-2 md:px-3">
					<label class="font-bold"><b class="text-red-500">*</b> User Type</label><br><br>
					<select class="w-full border border-green-200 h-12 px-2 uppercase text-center" v-model="user.user_type">
					  <option value="admin">LGU - Admin</option>
					  <option value="employee">LGU - Employee</option>
					  <option value="health-worker">LGU - Health Worker</option>				  
						<option value="citizen">Citizen</option>
					</select>
					<span class="text-sm text-red-500">{{validationError('user_type', saveError)}} </span>
				</div>

				<div class="w-full px-2 md:px-3" v-if="options.user && !!options.user.identification_image">
					<label class="font-bold"> Valid ID</label><br><br>
					<img
            :src="options.user.identification_image"
            style="height: 200px; width: 100%;"
            alt=""
          />
				</div>
			</div>
		</div>
	</div>
</template>



<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../../Layouts/Navigation";
	import Toggle from "../../Components/Toggle";

	export default {
		props: ["options"],
		components: {
		    Nav,
		    Toggle
		},
		data() {
			return {
				openModal: false,
				user: {
					id: null,
					first_name: null,
					middle_name: null,
					last_name: null,
					email: null,
					user_type: null,
					phone: null,
					is_active: 0,
					agree: 1,
					perspective: null,
				},
				saveError: null
			}
		},

		mounted(){

			if(this.options.user) {
				let current = {
					id: this.options.user.id,
					first_name: this.options.user.first_name,
					middle_name: this.options.user.middle_name,
					last_name: this.options.user.last_name,
					email: this.options.user.email,
					phone: this.options.user.phone,
					is_active: this.options.user.is_active,
					user_type: this.options.user.user_type,
					agree: this.options.user.agree,
					perspective: this.options.user.perspective
				}

				this.user = Object.assign(this.user, current)
			}
			
		},

		methods: {
			back() {
				Inertia.get(
          this.$root.route + '/users/', {},
          {
            onSuccess: () => { },
          },
        );
			},

			save() {
				this.saveUser = null

				Inertia.post(this.$root.route + "/users/saveUser", this.user,
          {
            onSuccess: (res) => {
            },
            onError: (err) => {
            	this.saveError = err
            }
        });
			}
		},

		watch: {
			'user.user_type': function (type) {
				this.user.perspective = 1
				
				if(type == 'citizen') {
					this.user.perspective = 3
				}
			}
		}
	}
</script>

<style scoped>

</style>