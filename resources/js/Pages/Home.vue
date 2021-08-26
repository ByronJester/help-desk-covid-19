<template>
	<div class="w-screen">
		<Login :openModal.sync="openModal"/>

		<Nav :user.sync="options.user" :openModal.sync="openModal"/>

		<div class="flex flex-col mt-10 mb-5 items-center" v-if="!openModal">
		  <div class="w-4/5 md:w-2/5 bg-gray-300 rounded" v-if="isAuthorize('save_post', options.user)">
		  	<div class="px-5 my-2 md:my-5">
			  	<label class="text-xs md:text-lg uppercase font-bold"> What's new announcement ?</label><br><br>
			
			  	<textarea rows="4" class="text-xs md:text-lg rounded px-2 py-2 border border-green-500 w-full" v-model="form.content">
					</textarea>

					<input type="file" ref="post_image" @change="imageChange('post_image', $event)" accept="image/png, image/jpeg" style="display:none">
					<i class="fa fa-image fa-lg md:fa-2x cursor-pointer" @click="uploadImage('post_image')"></i>
					
				</div>

				<div class="px-5 my-2" v-if="form.images.length > 0">
			  	<carousel :navigationEnabled="false" :perPage="1" :paginationEnabled="true" class="w-full">
			      <slide style="height: 250px" v-for="(image, i) in form.images" :key="i">
			    		 <img
	              :src="image"
	              :style="{ 'height': '250px' }"
	              class="w-full"
	              alt=""
	            />
			      </slide>
			    </carousel>
				</div>

				<div class="px-5 mb-2 mt-2 md:mb-5 md:mt-5">
			  	<button class="rounded bg-blue-700 py-2 md:py-4 font-bold text-xs md:text-lg w-full uppercase text-white"
			  		@click="newPost()"
			  	>
			  		Post
			  	</button>
				</div>
		  </div>

			<div class="w-4/5 md:w-2/5 bg-gray-200 my-5 rounded" v-for="post in options.posts">
				<div class="py-3 px-3">
					<p class="tex-lg font-bold my-2">
			  		{{post.user.first_name}} {{post.user.last_name}}
			  	</p>

			  	<p class="tex-base">
			  		{{post.content}}
			  	</p>

			  	<carousel class="mt-3" :navigationEnabled="false" :perPage="1" :paginationEnabled="true" v-if="post.images.length > 0">
			      <slide class="w-full" style="height: 250px" v-for="(image, i) in post.images" :key="i">
			    		 <img
	              :src="'/images/posts/' + image.image"
	              class="w-full"
	              :style="{ 'height': '250px' }"
	              alt=""
	            />
			      </slide>
			    </carousel>
			  </div>
		  </div>
		</div>

	</div>

</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Nav from "../Layouts/Navigation";
	import Login from "./Users/Login";
	import Toggle from "../Components/Toggle";

	export default {
		props: ['options'],
		components: {
		    Login,
		    Nav,
		    Toggle
		},
		data() {
			return {
				openModal: false,
				form: {
					content : null,
					images: []
				},
				formData: new FormData()
			}
		},

		mounted() {
			if(!!this.options.user) {
				this.openModal = false
			}
		},

		methods : {
			uploadImage(arg) {
				this.$refs[arg].click()
			},

			imageChange(arg, e) {
	      const image = e.target.files[0];

	      this.formData.append('images[]', image);

        const reader = new FileReader();

        reader.readAsDataURL(image);

        reader.onload = e =>{
          this.form.images.push(e.target.result)
        };
			},

			newPost() {
				this.formData.append('content', this.form.content)

				Inertia.post(this.$root.route + "/home/save-post", this.formData,
          {
            onSuccess: (res) => {
            	this.formData = new FormData()

            	this.form.content = null
            	this.form.images = []
            },

            onError: (err) => {
            	
            }
        });
			}
		}
	}

</script>

<style scoped>
	.--home {
		height: 100vh;
		width: 100vw;
	}

	textarea {
    overflow: auto;
    outline: none;

    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;

    resize: none; /*remove the resize handle on the bottom right*/
	}
</style>