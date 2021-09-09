<template>
	<div v-if="viewCase" class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center flex mt-40">
		<div class="relative mx-auto w-screen md:w-3/6" >
        <div  class="relative p-6 flex-auto overflow-x-hidden overflow-y-auto bg-gray-100" >
	 				<div class="w-full float-right text-2xl cursor-pointer" @click="$emit('update:viewCase', false)">x</div>

	 				<div class="w-full flex flex-col">

	 					<div class="flex flex-col md:flex-row w-full">
	 						<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
								<label class="font-bold"> Patient</label><br><br>
								<input type="text" v-model="form.code" placeholder="Patient" class="w-full border border-green-200 h-10 text-center">
								<span class="text-sm text-red-500">{{validationError('code', errors)}} </span>
							</div>

							<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
								<label class="font-bold"> Age</label><br><br>
								<input type="number" v-model="form.age" placeholder="Age" class="w-full border border-green-200 h-10 text-center px-2">
								<span class="text-sm text-red-500">{{validationError('age', errors)}} </span>
							</div>
	 					</div>

	 					<div class="flex flex-col md:flex-row w-full">
	 						<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
		 						<label class="font-bold">Symptom</label><br><br>
								<textarea v-model="form.symptom" rows="2" class="w-full border border-green-200 px-2 py-2">
								
								</textarea>
								<span class="text-sm text-red-500">{{validationError('symptom', errors)}} </span>
							</div>
	 					</div>

	 					<div class="flex flex-col md:flex-row w-full">
	 						<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
								<label class="font-bold">Gender</label>
								<select v-model="form.gender" class="w-full border border-green-200 px-2 py-2">
								  <option value="MALE">MALE</option>
								  <option value="FEMALE">FEMALE</option>
								</select>
								<span class="text-sm text-red-500">{{validationError('gender', errors)}} </span>
							</div>

							<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
								<label class="font-bold">Status</label>
								<select v-model="form.status" class="w-full border border-green-200 px-2 py-2">
								  <option value="RECOVERED">RECOVERED</option>
								  <option value="DEATH">DEATH</option>
								  <option value="QUARANTINE">QUARANTINE</option>
								</select>
								<span class="text-sm text-red-500">{{validationError('status', errors)}} </span>
							</div>

							
	 					</div>

	 					<div class="flex flex-col md:flex-row w-full">
							<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
								<label class="font-bold"> Travel History</label><br><br>
								<input type="text" v-model="form.travel_history" placeholder="Travel History" class="w-full border border-green-200 h-10 text-center">
								<span class="text-sm text-red-500">{{validationError('travel_history', errors)}} </span>
							</div>

							<div class="w-full py-2 md:px-20 mt-2 md:mt-2">
								<label class="font-bold"> Date</label><br><br>
								<input type="date" v-model="form.date" placeholder="Date" class="w-full border border-green-200 h-10 text-center">
								<span class="text-sm text-red-500">{{validationError('date', errors)}} </span>
							</div>
	 					</div>

	 					<div class="w-full mt-2 md:my-4 md:px-20">
	 						<button class="w-full py-2 px-3 bg-green-500 text-center font-bold text-white" @click="save()"> 
	 							Save
	 						</button>
	 					</div>


	 				</div>
			 	</div>
		</div>

	</div>

	

</template>

<script>
	import { Inertia } from "@inertiajs/inertia";

	export default {
		props: ['viewCase', 'form'],
		data() {
			return {
				errors: null
			}
		},
 
		methods: {
			save() {
				Inertia.post(this.$root.route + "/virus-cases/save", this.form, 
          {
            onSuccess: () => { 
            	this.$emit('update:viewCase', false)
            },

            onError: (err) => {
            	this.errors = err
            }
          });
			}
		},

		watch : {
			viewCase: function (v) {
				if(!v) this.errors = null;
			}
		}
	}


</script>