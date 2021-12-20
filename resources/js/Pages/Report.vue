<template>
	<div class="min-h-screen">
		<div class="--report overflow-x-hidden"> 
			<Login :openModal.sync="openModal"/>

			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full" v-if="path == '/reports/cases'">

				<div class="w-full" v-if="!openModal">
					<select class="border border-green-300 py-2 px-2 mx-2" v-model="filter">
						<option value="1">Reports</option>
					  <option value="2">Brangays</option>
					</select>
				</div>

				<ReportsCarousel :records="options.records" :vaccinations="options.vaccinations" :path="path"
					v-if="filter == 1 && !openModal"
					class="px-3 md:px-20" 
				/>

				<PlacesCarousel :places.sync="options.places" :selected.sync="selected" 
					v-if="filter == 2 && !openModal" 
					class="px-3 md:px-20"
				/>
			</div> 

			<div class="w-full mt-40" v-if="path == '/reports/pending-vaccination' || path == '/reports/finish-vaccination'">
				<div class="md:text-4xl font-bold mb-16 ml-20">
					{{path == '/reports/pending-vaccination' ? 'Vaccination Approval List' : 'Vaccinated List' }}
				</div>

				<VaccinationCarousel :vaccinations.sync="path == '/reports/pending-vaccination' ? options.pendingVaccination : options.finishVaccination" 
					v-if="!openModal" 
					class="px-3 md:px-20"
				/>
			</div> 

			<div class="w-full" v-if="path != '/reports/cases'">
				<div class="w-full flex justify-center items-center">
					<div class="w-full flex flex-col md:flex-row px-2 md:px-0">

						<div class="w-full flex flex-col bg-gray-300 md:mx-4 px-2 rounded my-2 md:my-0"
							v-if="path == '/reports/vaccinations' && !openModal"
						>
							<div class="w-full font-bold pt-5 pl-5">
								<span class="md:text-4xl">Vaccination Form</span>

								<button class="rounded text-white border border-green-400 bg-green-600 px-3 py-3 font-bold float-right"
									@click="sendVaccineForm"
									v-if="options.user"
								>
									Submit
								</button>
							</div>

							<div class="w-full flex flex-row px-3">
								<div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"><b class="text-red-500">*</b> Name</label><br><br>
									<input type="text" v-model="form.name" class="w-full border border-green-200 h-12 text-center">
									<span class="text-sm text-red-500">{{validationError('name', saveError)}} </span>
								</div>

								<div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"><b class="text-red-500">*</b> Age</label><br><br>
									<input type="number" v-model="form.age" class="w-full border border-green-200 h-12 text-center">
									<span class="text-sm text-red-500">{{validationError('age', saveError)}} </span>
								</div>
							</div>

							<div class="w-full flex flex-row px-3">
								<div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"><b class="text-red-500">*</b> Birthdate</label><br><br>
									<input type="date" v-model="form.birth_date" class="w-full border border-green-200 h-12 text-center">
									<span class="text-sm text-red-500">{{validationError('birth_date', saveError)}} </span>
								</div>

								<div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"><b class="text-red-500">*</b> Barangay</label><br><br>
									<select v-model="form.place_id" class="w-full border border-green-200 h-12 text-center">
									  <option v-for="place in options.places":value="place.id" class="uppercase">
									  	{{place.name}}
									  </option>
									</select>
									<span class="text-sm text-red-500">{{validationError('place_id', saveError)}} </span>
								</div>
							</div>

							<div class="w-full flex flex-row px-3">
								<div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"><b class="text-red-500">*</b> Contact No.</label><br><br>
									<input type="number" v-model="form.phone" placeholder="639xxxxxxxxx" class="w-full border border-green-200 h-12 text-center">
									<span class="text-sm text-red-500">{{validationError('phone', saveError)}} </span>
								</div>

								<div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"><b class="text-red-500">*</b> Gender</label><br><br>
									<select v-model="form.gender" class="w-full border border-green-200 h-12 text-center">
										<option value="MALE">Male</option>
									  <option value="FEMALE">Female</option>
									</select>
									<span class="text-sm text-red-500">{{validationError('gender', saveError)}} </span>
								</div>
							</div>

							<div class="w-full flex flex-row px-3">
								<!-- <div class="w-full py-2 mt-2 md:mt-3 mx-2">
									<label class="font-bold"> Vaccine</label><br><br>
									<select v-model="form.vaccine_id" class="w-full border border-green-200 h-12 text-center">
									  <option v-for="vaccine in options.vaccines":value="vaccine.id" class="uppercase">
									  	{{vaccine.name}}
									  </option>
									</select>
									<span class="text-sm text-red-500">{{validationError('vaccine_id', saveError)}} </span>
								</div> -->

								<div class="w-full py-2 mt-2 md:mt-3 mx-2 pb-5">
									<label class="font-bold"><b class="text-red-500">*</b>Classification</label><br><br>
									<select v-model="form.classification" class="w-full border border-green-200 h-12">
									  <option value="A1">A1 - Workers in frontline healt services</option>
									  <option value="A2">A2 - All senior citizens</option>
									  <option value="A3">A3 - Person with comorbidities</option>
									  <option value="A4">A4 - Frontline personnel in essential sectors, including uniformed personnel</option>
									  <option value="A5">A5 - Indigent population</option>
									  <option value="B1">B1 - Teachers, social workers</option>
									  <option value="B2">B2 - Other government workers</option>
									  <option value="B3">B3 - Other essential workers</option>
									  <option value="B4">B4 - Socio-demographic groups at significantly higher risk other than senior citizens and poor population base on the NHTS-PR</option>
									  <option value="B5">B5 - Overseas filipino workers</option>
									  <option value="B6">B6 - Other remaining workforce</option>
									  <option value="C">C - Rest of the filipino population not otherwise included in the above groups</option>
									</select>
									<span class="text-sm text-red-500">{{validationError('classification', saveError)}} </span>
								</div>
							</div>
						</div>

						<div class="w-full flex flex-col bg-gray-300 md:mx-4 rounded my-2 md:my-0 text-center md:text-left"
							v-if="path == '/reports/vaccinations-classification' && !openModal"
						>
							<div class="w-full md:text-4xl font-bold pt-5 pl-5 mb-10">
								Vaccination Priority
							</div>

							<div class="w-full py-2 md:px-20 mt-2 mb-5 flex flex-col md:flex-row">

								<div class="w-full">
									<p class="font-bold md:text-2xl my-3">
										Prioriry Eligable A
									</p>

									<p class="text-sm md:text-xl my-2">
										A1. Workers in frontline healt services
									</p>

									<p class="text-sm md:text-xl my-2">
										A2. All senior citizens
									</p>

									<p class="text-sm md:text-xl my-2">
										A3. Person with comorbidities
									</p>

									<p class="text-sm md:text-xl my-2">
										A4. Frontline personnel in essential sectors, including uniformed personnel
									</p>

									<p class="text-sm md:text-xl my-2">
										A5. Indigent population
									</p>

								</div>

								<div class="w-full">
									<p class="font-bold md:text-2xl my-3">
										Prioriry Eligable B
									</p>

									<p class="text-sm md:text-xl my-2">
										B1. Teachers, social workers
									</p>

									<p class="text-sm md:text-xl my-2">
										B2. Other government workers
									</p>

									<p class="text-sm md:text-xl my-2">
										B3. Other essential workers
									</p>

									<p class="text-sm md:text-xl my-2">
										B4. Socio-demographic groups at significantly higher risk other than senior citizens and poor population base on the NHTS-PR
									</p>

									<p class="text-sm md:text-xl my-2">
										B5. Overseas filipino workers
									</p>

									<p class="text-sm md:text-xl my-2">
										B6. Other remaining workforce
									</p>
								</div>

								<div class="w-full">
									<p class="font-bold md:text-2xl my-3">
										Prioriry Eligable C
									</p>

									<p class="text-sm md:text-xl my-2">
										C. Rest of the filipino population not otherwise included in the above groups
									</p>
								</div>
							</div>
							
						</div>

						<div class="w-full flex flex-col bg-gray-300 md:mx-4 rounded my-2 md:my-0 text-center md:text-left"
							v-if="path == '/reports/vaccinations-information' && !openModal"
						>
							<div class="w-full md:text-4xl font-bold pt-5 pl-5 mb-10">
								Vaccinations Information
							</div>

							<div class="w-full py-2 md:px-20 mt-2 flex flex-col md:flex-row">
								<div class="w-full">
									<p class="font-bold md:text-2xl my-3">
										Benefits
									</p>

									<p class="text-sm md:text-xl my-2">
										1. COVID 19-vaccines are effective. They can keep you from getting and spreading the virus that causes COVID-19
									</p><br>

									<p class="text-sm md:text-xl my-2">
										2. COVID-19 vaccines also help keep you from getting seriously ill even if you do get COVID-19.
									</p><br>

									<p class="text-sm md:text-xl my-2">
										3. Getting vaccinated yourself may also protect people around you, particularly people at increased risk for severe illness from COVID-19.
									</p><br>
								</div>

								<div class="w-full">
									<p class="font-bold md:text-2xl">
										Side Effects
									</p>

									<p class="text-sm md:text-xl my-2">
										Like any vaccine, COVID-19 vaccines can cause mild, short term side effects, such as a low-grade fever or pain or redness at the injection site. Most reactions to vaccines are mild and go away within a few days on their own. More serious or long-lasting side effects to vaccines are possible but extremely rare. Vaccines are continually monitored for as long as they are in use, to detect rare adverse events and implement approaches to limit their occurrence. <br><br>

										Reported side effects to COVID-19 vaccines have mostly been mild to moderate and short-lasting. They include: fever, fatigue, headache, muscle pain, chills, diarrhoea, and pain at the injection site. The chances of any of these side effects following vaccination differ according to the specific COVID-19 vaccine. <br>
									</p>
								</div>

							</div>
						</div>
					</div>
				</div>
				
				<!-- <hr style="height:2px; border-width:0" class="text-green-500 bg-green-500 mt-8" v-if="!openModal"> -->

				<ReportsCarousel :records="null" :vaccinations="options.vaccinations" :path="path"
					class="px-3 md:px-20" v-if="!openModal && options.vaccinations.length > 0" 
				/>
			</div>
			
		</div> 
	</div>

</template>

<script> 
	import { Carousel, Slide } from 'vue-carousel';
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Login from "./Users/Login";
	import PlacesCarousel from "./Places/PlacesCarousel";
	import ReportsCarousel from "./Reports/ReportsCarousel";
	import VaccinationCarousel from "./Vaccinations/VaccinationCarousel";

	export default {
		props: ['options'],
		components: {
			Carousel,
      	Slide,
		    Login,
		    Nav,
		    PlacesCarousel,
		    ReportsCarousel,
		    VaccinationCarousel
		},
		data() {
			return {
				openModal: false,
				selected: null,
				filter: 1,
				path: null,
				form: {
					place_id: 1,
					vaccine_id: null,
					name: null,
					age: null,
					birth_date: null,
					classification: 'A1',
					gender: 'MALE',
					phone: null
				},
				saveError: null
			}
		},

		created() {
			if(!!this.options.user) {
				this.openModal = false
			}

			this.path = window.location.pathname
		},

		methods : {
			sendVaccineForm() {
				Inertia.post(this.$root.route + "/reports/vaccinations/submit-request", this.form,
          {
            onSuccess: (res) => {
            	this.form = {
								place_id: 1,
								vaccine_id: null,
								name: null,
								age: null,
								birth_date: null,
								classification: 'A1',
								gender: 'MALE',
								phone: null
							}
            },
            onError: (err) => {
            	this.saveError = err
            	console.log(err)
            }
        });
			}
		},

		watch: {
			selected: function (v) {
				Inertia.get(
          this.$root.route + '/reports/cases/view/' + v.id, {},
          {
            onSuccess: () => { },
          },
        );
			},

			filter: function (v) {
				
			}
		}
	}

</script>

<style scoped>
	.--report {
		height: 100vh;
		width: 100vw;
	}

	.--report::-webkit-scrollbar {
	    display: none;
	}

	/* Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	  margin: 0;
	}

	/* Firefox */
	input[type=number] {
	  -moz-appearance: textfield;
	}
</style>