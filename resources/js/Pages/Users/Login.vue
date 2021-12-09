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

		 				<div class="flex flex-col md:flex-row w-full mt-5">
		 					<div class="w-full md:mx-2">
								<label class="font-bold"> Valid ID</label><br><br>
								<span class="text-sm text-red-500">
									{{validationError('identification_image', registerErrors)}} 
								</span>

								<img
		              :src="register.identification_image"
		              style="height: 300px; width: 100%;"
		              @click="uploadImage('identification')" 
		              class="cursor-pointer"
		              alt=""
		            />
		            <input type="file" ref="identification" 
		            	@change="imageChange('identification', $event)" 
		            	accept="image/png, image/jpeg" 
		            	style="display:none"
		            >
							</div>
		 				</div> 

		 				<div class="flex flex-col md:flex-row w-full mt-5">
		 					<div class="w-full md:mx-2">
								<Toggle v-model="register.agree"  class="mr-5 mt-2"/>
								<label class="font-bold"> 
									<p> I agree to 
										<span class="underline text-blue-500 cursor-pointer"
											@click="goTermsAndCondition"
										>
											terms and condition
										</span> 
										of this site.</p> 
								</label>
							</div>
		 				</div> 

		 				<div class="flex flex-col md:flex-row w-full mt-5" v-if="viewTerms">
		 					<div class="w-full md:mx-2">
		 						At Online Help Desk Information System For COVID-19, we take privacy seriously and we respect the concerns of our community of users, in this policy we describe our privacy practices with regard to information we collect through help-desk-covid-19. The help-desk-covid-19 helps you to make informed decisions about how you share information when you visit or use the site.
		 					</div>
		 				</div>

		 				<div class="flex flex-col md:flex-row w-full">
		 					<div class="w-full md:mx-2">
		 						<button :disabled="!register.agree" :class="{ 'cursor-not-allowed' : !register.agree}"
			 						class="w-full rounded bg-blue-400 border border-green-100 text-white h-12 mt-3 md:mr-1" 
			 						@click="registerAcc()"
		 						>
		 							Register
		 						</button>
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
	import Toggle from "../../Components/Toggle";

	export default {
		props: ['openModal'],
		components: {
		    Toggle
		},
		data() {
			return {
				is_login: true,
				login: {
					email: null,
					password: null
				},
				register: {
					id: null,
					first_name: '',
					middle_name: '',
					last_name: '',
					phone: '',
					email: '',
					password: '',
					confirm_password: '',
					user_type: 'admin - lgu',
					perspective: '',
					is_active: false,
					identification_image: '/images/identifications/default.png',
					agree: false
				},
				loginError: null,
				registerErrors: null,
				formData: new FormData(),
				viewTerms: false
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
            		this.register.first_name = ''
                this.register.middle_name = ''
                this.register.last_name = ''
                this.register.phone = ''
                this.register.email = ''
                this.register.password = ''
                this.register.confirm_password = ''
                this.register.user_type = 'admin - lgu'
                this.register.perspective = ''
                this.register.identification_image = '/images/identifications/default.png'
              	this.register.agree = false

                this.openModal = false 
                this.is_login = false
            	} else {
            		this.loginError = res.props.message
            	}
          	}
        });
			},

			registerAcc() {
				// switch(this.register.user_type) {
				//   case 'admin - lgu':
				//     this.register.perspective = 1
				//     this.register.user_type = 'admin'
				//     this.register.is_active = false
				//     break;

				//   case 'employee - lgu':
				//     this.register.perspective = 1
				//     this.register.user_type = 'employee'
				//     this.register.is_active = false
				//     break;

				//   case 'health-worker - lgu':
				//     this.register.perspective = 1
				//     this.register.user_type = 'health-worker'
				//     this.register.is_active = false

				//   case 'citizen':
				//     this.register.perspective = 3
				//     this.register.user_type = 'citizen'
				//     this.register.is_active = false
				//     break;
				// }

				if(this.register.user_type == 'admin - lgu') {
						this.register.perspective = 1
				    this.register.user_type = 'admin'
				    this.register.is_active = false
				}

				if(this.register.user_type == 'employee - lgu') {
						this.register.perspective = 1
				    this.register.user_type = 'employee'
				    this.register.is_active = false
				}

				if(this.register.user_type == 'health-worker - lgu') {
						this.register.perspective = 1
				    this.register.user_type = 'health-worker'
				    this.register.is_active = false
				}

				if(this.register.user_type == 'citizen') {
						this.register.perspective = 3
				    this.register.user_type = 'citizen'
				    this.register.is_active = false
				}

				this.formData.append('id', this.register.id);
				this.formData.append('first_name', this.register.first_name);
				this.formData.append('middle_name', this.register.middle_name);
				this.formData.append('last_name', this.register.last_name);
				this.formData.append('phone', this.register.phone);
				this.formData.append('email', this.register.email);
				this.formData.append('password', this.register.password);
				this.formData.append('confirm_password', this.register.confirm_password);
				this.formData.append('user_type', this.register.user_type);
				this.formData.append('perspective', this.register.perspective);
				this.formData.append('is_active', this.register.is_active);
				this.formData.append('agree', this.register.agree);

				Inertia.post(this.$root.route + "/users/saveUser", this.formData,
          {
          	headers: {
					    'Content-Type': 'multipart/form-data'
					  },
            onSuccess: (res) => {
            	this.$emit('update:openModal', false)
            	this.register.id = null
              this.register.first_name = ''
              this.register.middle_name = ''
              this.register.last_name = ''
              this.register.phone = ''
              this.register.email = ''
              this.register.password = ''
              this.register.confirm_password = ''
              this.register.user_type = 'admin - lgu'
              this.register.perspective = ''
              this.register.identification_image = '/images/identifications/default.png'
              this.register.agree = false

              this.openModal = false 
              this.is_login = false
            },
            onError: (err) => {
            	console.log(err)

            	this.register.user_type = 'admin - lgu'
            	this.registerErrors = err
            }
        });
			},

			uploadImage(arg) {
				this.$refs[arg].click()
			},

			imageChange(arg, e) {
	      const image = e.target.files[0];

	      this.formData = new FormData()

	      this.formData.append('identification_image', image);

        const reader = new FileReader();

        reader.readAsDataURL(image);

        reader.onload = e =>{
          this.register.identification_image = e.target.result
        };
			},

			goTermsAndCondition(){
				this.viewTerms = !this.viewTerms
			}
		}
	}
</script>