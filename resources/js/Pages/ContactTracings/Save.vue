<template>
	<div class="min-h-screen overflow-x-hidden">
		<div class="--tracing">
			<Nav :user.sync="options.user" :openModal.sync="openModal"/>

			<div class="w-full text-lg md:text-4xl md:px-10">
				<i class="fa fa-arrow-left cursor-pointer ml-3 md:ml-10" @click="back()"></i> 
				<span class="ml-3" v-if="!!options.tracing">{{options.tracing.name}} </span>
				<span class="ml-3" v-else> ADD NEW TRACING </span>

				<button 
					class="rounded bg-green-400 border border-green-100 text-white px-1 py-1 md:px-5 md:py-3 float-right md:text-2xl mr-2" 
					@click="save()"
				>
					Save
				</button>

				<button 
					class="rounded bg-yellow-400 border border-yellow-100 text-white px-1 py-1 md:px-5 md:py-3 float-right md:text-2xl mr-2" v-if="form.id != null"
					@click="changeStatus(!!form.is_active ? false : true)"
				>
					{{ !!form.is_active ? 'Archive' : 'Restore' }}
				</button>
			</div>

			<div class="w-full flex flex-col mt-20 md:px-32">
				<div class="w-full flex flex-col md:flex-row py-3 md:py-20">
					<div class="w-full px-2 md:px-3">
						<label class="font-bold"><b class="text-red-500">*</b> Name</label><br><br>
						<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="form.name">
						<!-- <span class="text-sm text-red-500">{{validationError('name', saveError)}} </span> -->
					</div>

					<div class="w-full px-2 md:px-3">
						<label class="font-bold"><b class="text-red-500">*</b> Phone</label><br><br>
						<input type="text" class="w-full border border-green-200 h-12 text-center" v-model="form.phone">
						<!-- <span class="text-sm text-red-500">{{validationError('phone', saveError)}} </span> -->
					</div>

				</div>

				<div class="w-full flex flex-col md:flex-row py-3 md:py-20">
					<div class="w-full px-2 md:px-3">
						<label class="font-bold"><b class="text-red-500">*</b> Birthdate</label><br><br>
						<input type="date" class="w-full border border-green-200 h-12 text-center" v-model="form.birth_date">
						<!-- <span class="text-sm text-red-500">{{validationError('birth_date', saveError)}} </span> -->
					</div>

					<div class="w-full px-2 md:px-3">
						<label class="font-bold mt-2"><b class="text-red-500">*</b> Gender</label>
						<select v-model="form.gender" class="w-full border border-green-200 px-2 py-3 mt-6">
						  <option value="MALE">MALE</option>
						  <option value="FEMALE">FEMALE</option>
						</select>
						<!-- <span class="text-sm text-red-500">{{validationError('gender', errors)}} </span> -->
					</div>

					
				</div>
			</div>

			
		</div>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../../Layouts/Navigation";


	export default {
		props: ['options'],
		components: {
		    Nav
		},

		data() {
			return {
				openModal: false,
				form: {
					id: null,
					place_id: this.options.place,
					name: null,
					birthdate: null,
					phone: null,
					gender: 'MALE',
				}
			}
		},

		created() {
			if(!!this.options.tracing) {
				this.form = Object.assign({}, this.options.tracing)
			}
		},

		methods: {
			back() {
				Inertia.get(
          this.$root.route + '/contact-tracing/', {},
          {
            onSuccess: () => { },
          },
        );
			},

			save() {
				Inertia.post(
          this.$root.route + '/contact-tracing/save', this.form,
          {
            onSuccess: () => { },
          },
        );
			},

			changeStatus(arg) {
				let data = {
					id: this.form.id,
					is_active: arg
				}

				Inertia.post(
          this.$root.route + '/contact-tracing/change-status', data,
          {
            onSuccess: () => { },
          },
        );
			}
		}


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