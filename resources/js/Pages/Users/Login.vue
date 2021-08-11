<template>
	<div v-if="openModal" class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center flex mt-40">
	    <!-- Login -->
	    <div class="relative mx-auto w-screen md:w-3/6" >
          	<div v-if="!!is_login" class="relative p-6 flex-auto overflow-x-hidden overflow-y-auto bg-gray-100" >
 				<div class="w-full float-right text-2xl cursor-pointer" @click="$emit('update:openModal', false)">x</div>

				<div class="w-full">
	 				<div class="w-full py-2 md:px-20 mt-2 md:mt-7">
						<label class="font-bold"> Email</label><br><br>
						<input type="text" placeholder="example@gmail.com" class="w-full border border-green-200 h-12 text-center" v-model="login.email">
					</div>

					<div class="w-full py-2 md:px-20 mt-2 md:mt-7">
						<label class="font-bold"> Password</label><br><br>
						<input type="password" placeholder="Password" class="w-full border border-green-200 h-12 text-center" v-model="login.password">
					</div>

					<div class="flex flex-col md:flex-row w-full mt-8">
	 					<div class="w-full md:mx-2">
	 						<button class="w-full rounded bg-blue-400 border border-green-100 text-white h-12 mt-3 md:mr-1" @click="is_login = false">Register Account</button>
	 					</div>

	 					<div class="w-full md:mx-2">
	 						<button class="w-full rounded bg-green-400 border border-green-100 text-white h-12 mt-3 md:ml-1" @click="loggedAcc()">Login</button>
	 					</div>
	 				</div>
				</div>
		 	</div>
	
	        

	        <div v-else class="relative p-6 flex-auto overflow-x-hidden overflow-y-auto bg-gray-100">
 				<div class="w-full float-right text-2xl cursor-pointer" @click="$emit('update:openModal', false)">x</div>

				<div class="w-full">
	 				<div class="flex flex-col md:flex-row w-full mt-5">
	 					<div class="w-full md:mx-2">
							<label class="font-bold"> First Name</label><br><br>
							<input type="text" placeholder="First Name" class="w-full border border-green-200 h-12 text-center" v-model="register.first_name">
						</div>

						<div class="w-full md:mx-2">
							<label class="font-bold"> Middle Name</label><br><br>
							<input type="text" placeholder="Middle Name (optional)" class="w-full border border-green-200 h-12 text-center" v-model="register.middle_name">
						</div>

						<div class="w-full md:mx-2">
							<label class="font-bold"> Last Name</label><br><br>
							<input type="text" placeholder="Last Name" class="w-full border border-green-200 h-12 text-center" v-model="register.last_name">
						</div>
	 				</div>

	 				<div class="flex flex-col md:flex-row w-full mt-5">
	 					<div class="w-full md:mx-2">
							<label class="font-bold"> Phone Number</label><br><br>
							<input type="text" placeholder="09xxxxxxxxx" class="w-full border border-green-200 h-12 text-center" v-model="register.phone">
						</div>

						<div class="w-full md:mx-2">
							<label class="font-bold"> Email Address</label><br><br>
							<input type="text" placeholder="email@example.com" class="w-full border border-green-200 h-12 text-center" v-model="register.email">
						</div>
	 				</div>

	 				<div class="flex flex-col md:flex-row w-full mt-5">
	 					<div class="w-full md:mx-2">
							<label class="font-bold"> Password</label><br><br>
							<input type="password" placeholder="Password" class="w-full border border-green-200 h-12 text-center" v-model="register.password">
						</div>

						<div class="w-full md:mx-2">
							<label class="font-bold"> Confirm Password</label><br><br>
							<input type="password" placeholder="Confirm Password" class="w-full border border-green-200 h-12 text-center" v-model="register.confirm_password">
						</div>
	 				</div>

	 				<div class="flex flex-col md:flex-row w-full mt-8">
	 					<div class="w-full md:mx-2">
	 						<button class="w-full rounded bg-blue-400 border border-green-100 text-white h-12 mt-3 md:mr-1" @click="registerAcc()">Register</button>
	 					</div>

	 					<div class="w-full md:mx-2">
	 						<button class="w-full rounded bg-green-400 border border-green-100 text-white h-12 mt-3 md:ml-1" @click="is_login = true">Login Account</button>
	 					</div>
	 				</div>


				</div>
		 	</div>
	    </div>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";

	export default {
		props: ['openModal'],
		data() {
			return {
				is_login: true,
				login: {
					email: null,
					password: null
				},
				register: {
					first_name: null,
					middle_name: null,
					last_name: null,
					phone: null,
					email: null,
					password: null,
					confirm_password: null,
					user_type: 'citizen',
					perspective: 3
				}
			}
		},

		mounted() {
		},

		methods: {
			loggedAcc() {
				Inertia.post(this.$root.route + "/users/login", this.login,
		          {
		            onSuccess: () => {
		            	this.$emit('update:openModal', false)

		                this.register.first_name = null
		                this.register.middle_name = null
		                this.register.last_name = null
		                this.register.phone = null
		                this.register.email = null
		                this.register.password = null
		                this.register.confirm_password = null
		                this.register.user_type ='citizen'
		                this.register.perspective = 3

		                this.openModal = false 
		                this.is_login = false
		              }
		          });
			},

			registerAcc() {
				Inertia.post(this.$root.route + "/users/register", this.register,
		          {
		            onSuccess: () => {
		            	this.$emit('update:openModal', false)

		                this.register.first_name = null
		                this.register.middle_name = null
		                this.register.last_name = null
		                this.register.phone = null
		                this.register.email = null
		                this.register.password = null
		                this.register.confirm_password = null
		                this.register.user_type ='citizen'
		                this.register.perspective = 3

		                this.openModal = false 
		                this.is_login = false
		              }
		          });
			}
		}
	}
</script>