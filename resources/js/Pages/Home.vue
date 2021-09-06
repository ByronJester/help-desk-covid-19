<template>
	<div class="--home overflow-x-hidden">
		<Login :openModal.sync="openModal"/>

		<Nav :user.sync="options.user" :openModal.sync="openModal"/>

		<div class="flex flex-col mt-10 mb-5 items-center" v-if="!openModal">
		  <div class="w-4/5 md:w-2/5 bg-gray-300 rounded" v-if="isAuthorize('save_post', options.user)">
		  	<div class="px-5 my-2 md:my-5">
			  	<label class="text-xs md:text-lg uppercase font-bold"> What's new announcement ?</label><br><br>
			
			  	<textarea rows="4" class="text-xs md:text-lg rounded px-2 py-2 border border-green-500 w-full" v-model="form.content">
					</textarea>

					<input type="file" ref="post_image" @change="imageChange('post_image', $event)" accept="image/png, image/jpeg" style="display:none">

					<i class="fa fa-image fa-lg md:fa-2x cursor-pointer" 
						@click="uploadImage('post_image')"
						v-if="form.images.length == 0"
					>
					</i>
					
				</div>

				<div class="px-5 my-2" v-if="form.images.length > 0">
			  	<carousel :navigationEnabled="false" :perPage="1" :paginationEnabled="true" class="w-full">
			      <slide style="height: 250px" v-for="(image, i) in form.images" :key="i">
			      	<div class="--post-image">
				    		 <img
		              :src="image.image"
		              class="w-full h-full"
		              alt=""
		            />
		            <!-- <div class="--remove-icon cursor-pointer text-black" @click="removeImage(image.arg)">
		            	<i class="fa fa-times fa-2x"></i>
		            </div> -->
		          </div>
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
				<div class="flex items-center bg-yellow-400 text-white text-sm font-bold px-4 py-3" 
					role="alert"
					v-if="deleteId == post.id"
				>
				  <div class="tex-lg font-bold my-2 w-full">

			  		<span class="text-xs md:text-base"> 
			  			Are you sure to delete this post ? 
				  	</span> 
			  		<span class="float-right cursor-pointe text-xs md:text-base"
			  		>
			  			<button class="mx-1 md:mx-3" @click="deleteId = null"> No </button> 
			  			<button class="mx-1 md:mx-3" @click="deletePost(post.id)"> Yes </button>
			  		</span>
			  	</div>
				</div>

				<div class="py-3 px-3">
					<p class="tex-lg font-bold my-2">
			  		<span> {{post.user.first_name}} {{post.user.last_name}} </span> 
			  		
			  		<span class="float-right cursor-pointer mx-1" @click="deleteId = post.id"
			  			v-if="options.user && options.user.id == post.user_id"
			  		>
			  			<i class="fa fa-trash fa-lg md:fa-lg"></i>
			  		</span>

			  		<!-- <span class="float-right cursor-pointer mx-1" @click="editPost(post)"
			  			v-if="options.user && options.user.id == post.user_id"
			  		>
			  			<i class="fa fa-edit fa-lg md:fa-lg"></i>
			  		</span> -->
			  	</p>

			  	<p class="tex-base">
			  		{{post.content}}
			  	</p>

			  	<carousel class="mt-3" :navigationEnabled="false" :perPage="1" :paginationEnabled="true" v-if="post.images.length > 0">
			      <slide class="w-full" style="height: 250px" v-for="(image, i) in post.images" :key="i">
			      	<div class="--post-image">
				    		 <img
		              :src="image.image"
		              class="w-full"
		              :style="{ 'height': '250px' }"
		              alt=""
		            />
		            <!-- <div class="--remove-icon cursor-pointer text-black" 
		            	v-if="options.user && options.user.id == post.user_id"
		            >
		            	<i class="fa fa-edit fa-2x"></i>
		            </div> -->
		          </div>
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
					id: null,
					content : null,
					images: []
				},
				formData: new FormData(),
				deleteId: null,
				is_edit: false
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

	      // this.formData.get('images')



	      for (var key of this.formData.keys()) {
			   	// console.log(key);
				}

        const reader = new FileReader();

        reader.readAsDataURL(image);

        reader.onload = e =>{
          this.form.images.push({image: e.target.result, arg: image})
        };
			},

			newPost() {
				this.formData.append('id', this.form.id)
				this.formData.append('content', this.form.content)

				Inertia.post(this.$root.route + "/home/save-post", this.formData,
          {
            onSuccess: (res) => {
            	this.formData = new FormData()
            	this.form.id = null
            	this.form.content = null
            	this.form.images = []
            }, 

            onError: (err) => {
            	
            }
        });
			},

			deletePost(id) {
				Inertia.post(this.$root.route + "/home/delete-post", {id: id},
          {
            onSuccess: (res) => {
            	
            },

            onError: (err) => {
            	
            }
        });
			},

			removeImage(image) {
				
			}

			
		}
	}

</script>

<style scoped>
	.--home {
		height: 100vh;
		width: 100vw;
	}

	.--home::-webkit-scrollbar {
	  display: none;
	}

	/* Hide scrollbar for IE, Edge and Firefox */
	.--home {
	  -ms-overflow-style: none;  /* IE and Edge */
	  scrollbar-width: none;  /* Firefox */
	}

	textarea {
    overflow: auto;
    outline: none;

    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;

    resize: none; /*remove the resize handle on the bottom right*/
	}

	.--post-image {
	  position: relative;
	  text-align: center;
	  color: white;
	}

	.--remove-icon {
	  position: absolute;
	  top: 8px;
	  right: 16px;
	}
</style>