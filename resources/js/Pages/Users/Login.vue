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

						<span v-if="loginError" class="w-full py-2 md:px-20 mt-2 text-sm text-red-500">* {{loginError}}</span>

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
								<span class="text-sm text-red-500">{{validationError('first_name', registerErrors)}} </span>
							</div>

							<div class="w-full md:mx-2">
								<label class="font-bold"> Middle Name</label><br><br>
								<input type="text" placeholder="Middle Name (optional)" class="w-full border border-green-200 h-12 text-center" v-model="register.middle_name">
								<span class="text-sm text-red-500">{{validationError('middle_name', registerErrors)}} </span>
							</div>

							<div class="w-full md:mx-2">
								<label class="font-bold"> Last Name</label><br><br>
								<input type="text" placeholder="Last Name" class="w-full border border-green-200 h-12 text-center" v-model="register.last_name">
								<span class="text-sm text-red-500">{{validationError('last_name', registerErrors)}} </span>
							</div>
		 				</div>

		 				<div class="flex flex-col md:flex-row w-full mt-5">
		 					<div class="w-full md:mx-2">
								<label class="font-bold"> Phone Number</label><br><br>
								<input type="text" placeholder="09xxxxxxxxx" class="w-full border border-green-200 h-12 text-center" v-model="register.phone">
								<span class="text-sm text-red-500">{{validationError('phone', registerErrors)}} </span>
							</div>

							<div class="w-full md:mx-2">
								<label class="font-bold"> Email Address</label><br><br>
								<input type="text" placeholder="email@example.com" class="w-full border border-green-200 h-12 text-center" v-model="register.email">
								<span class="text-sm text-red-500">{{validationError('email', registerErrors)}} </span>
							</div>

							<div class="w-full md:mx-2"> 
								<label class="font-bold"> User Type</label><br><br>
								<select class="w-full border border-green-200 h-12 px-2 uppercase" v-model="register.user_type">
								  <option value="admin - lgu">LGU - Admin</option>
								  <option value="employee - lgu">LGU - Employee</option>
								  <option value="health-worker - lgu">LGU - Health Worker</option>
								  <!-- <option value="admin - hospital">Hospital - Admin</option>
								  <option value="employee - hospital">Hospital - Employee</option>
 -->								  
 									<option value="citizen">Citizen</option>
								</select>
								<span class="text-sm text-red-500">{{validationError('user_type', registerErrors)}} </span>
							</div>
		 				</div>

		 				<div class="flex flex-col md:flex-row w-full mt-5">
		 					<div class="w-full md:mx-2">
								<label class="font-bold"> Password</label><br><br>
								<input type="password" placeholder="Password" class="w-full border border-green-200 h-12 text-center" v-model="register.password">
								<span class="text-sm text-red-500">{{validationError('password', registerErrors)}} </span>
							</div>

							<div class="w-full md:mx-2">
								<label class="font-bold"> Confirm Password</label><br><br>
								<input type="password" placeholder="Confirm Password" class="w-full border border-green-200 h-12 text-center" v-model="register.confirm_password">
								<span class="text-sm text-red-500">{{validationError('confirm_password', registerErrors)}} </span>
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
					id: null,
					first_name: null,
					middle_name: null,
					last_name: null,
					phone: null,
					email: null,
					password: null,
					confirm_password: null,
					user_type: 'admin - lgu',
					perspective: null,
					is_active: false
				},
				loginError: null,
				registerErrors: null
			}
		},

		mounted() {
		},

		watch: {
			openModal: function (v) {
				if(!v) {
					this.registerErrors = null;
					this.is_login = true
				} 
			}
		},

		methods: {
			loggedAcc() {
				Inertia.post(this.$root.route + "/users/login", this.login,
          {
            onSuccess: (res) => {
            	if(!res.props.message) {

            		this.$emit('update:openModal', false)
            		this.register.id = null
            		this.register.first_name = null
                this.register.middle_name = null
                this.register.last_name = null
                this.register.phone = null
                this.register.email = null
                this.register.password = null
                this.register.confirm_password = null
                this.register.user_type = 'admin - lgu'
                this.register.perspective = null

                this.openModal = false 
                this.is_login = false
            	} else {
            		this.loginError = res.props.message
            	}
          	}
        });
			},

			registerAcc() {
				switch(this.register.user_type) {
				  case 'admin - lgu':
				    this.register.perspective = 1
				    this.register.user_type = 'admin'
				    this.register.is_active = false
				    break;

				  case 'employee - lgu':
				    this.register.perspective = 1
				    this.register.user_type = 'employee'
				    this.register.is_active = false
				    break;

				  case 'health-worker - lgu':
				    this.register.perspective = 1
				    this.register.user_type = 'health-worker'
				    this.register.is_active = false
				    break;

				  case 'admin - hospital':
				    this.register.perspective = 2
				    this.register.user_type = 'admin'
				    this.register.is_active = false
				    break;

				  case 'employee - hospital':
				    this.register.perspective = 2
				    this.register.user_type = 'employee'
				    this.register.is_active = false
				    break;

				   case 'citizen':
				    this.register.perspective = 3
				    this.register.user_type = 'citizen'
				    this.register.is_active = true
				    break;
				  default:
				}

				Inertia.post(this.$root.route + "/users/saveUser", this.register,
          {
            onSuccess: (res) => {
            	this.$emit('update:openModal', false)
            	this.register.id = null
              this.register.first_name = null
              this.register.middle_name = null
              this.register.last_name = null
              this.register.phone = null
              this.register.email = null
              this.register.password = null
              this.register.confirm_password = null
              this.register.user_type = 'admin - lgu'
              this.register.perspective = null

              this.openModal = false 
              this.is_login = false
            },
            onError: (err) => {
            	// console.log(err)

            	this.register.user_type = 'admin - lgu'
            	this.registerErrors = err
            }
        });
			}
		}
	}
</script>