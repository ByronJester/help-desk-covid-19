<template>
  <div class="w-full">

   <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 bg-green-800 mb-3">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
      <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
        <a class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white cursor-pointer">
          <span>
            <img
              :src="'/images/icon.jpg'"
              class="h-16 w-20 md:h-24 md:w-32"
              style="border-radius: 50%;"
              alt=""
            />
          </span>
        </a>
        <button class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block md:hidden outline-none focus:outline-none" type="button" @click="showNav()">
          <span class="block relative w-6 h-px rounded-sm bg-white"></span>
          <span class="block relative w-6 h-px rounded-sm bg-white mt-1"></span>
          <span class="block relative w-6 h-px rounded-sm bg-white mt-1"></span>

        </button>
      </div>

      <div class="md:flex flex-grow items-center block md:hidden" id="example-navbar-warning" v-if="!!is_collapse">
        <ul class="flex flex-col lg:flex-row list-none ml-auto text-base md:text-lg">
          <li class="nav-item mx-5" :class="{'--active' : active == '/home'}">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer" @click="changeActive('/home')">
              <i class="fa fa-home"></i> <span class="ml-2" >Home</span>
            </a>
          </li>
          <li class="nav-item mx-5">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
              <i class="fa fa-tv"></i><span class="ml-2">Bayan News</span>
            </a>
          </li>
          <li class="nav-item mx-5" :class="{'--active' : active == '/report'}">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"  @click="changeActive('/report')">
              <i class="fa fa-copy"></i><span class="ml-2" >Reports</span>
            </a>
          </li>

          <li class="nav-item mx-5" v-if="!user">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"@click="$emit('update:openModal', true)">
              <i class="fa fa-user-circle"></i><span class="ml-2">Sign in</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="md:flex flex-grow items-center hidden md:block" id="example-navbar-warning">
        <ul class="flex flex-col lg:flex-row list-none ml-auto text-base md:text-lg">
          <li class="nav-item mx-5" :class="{'--active' : active == '/home'}">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"  @click="changeActive('/home')">
              <i class="fa fa-home"></i> <span class="ml-2" >Home</span>
            </a>
          </li>
          <li class="nav-item mx-5">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
              <i class="fa fa-tv"></i><span class="ml-2">Bayan News</span>
            </a>
          </li>
          <li class="nav-item mx-5" :class="{'--active' : active == '/report'}">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer" @click="changeActive('/report')">
              <i class="fa fa-copy"></i><span class="ml-2" >Reports</span>
            </a>
          </li>

          <li class="nav-item mx-5" v-if="!user">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"@click="$emit('update:openModal', true)">
              <i class="fa fa-user-circle"></i><span class="ml-2">Sign in</span>
            </a>
          </li>
        </ul>
      </div>
      
    </div>
  </nav>

  </div>
</template>

<script>
  import { Inertia } from "@inertiajs/inertia";

  export default {
    props:['user', 'openModal'],
    data() {
      return {
        is_collapse: false,
        active: window.location.pathname
      }
    },
    mounted() {

    },

    methods: {
      showNav() {
        if(!!this.is_collapse) {
          this.is_collapse = false
        } else {
          this.is_collapse = true
        }
      },

      changeActive(arg) {
        Inertia.get(
          this.$root.route + arg, {},
          {
            onSuccess: () => { },
          },
        );
      }
    },


  }
</script>

<style scoped>
  .--active {
    border-bottom: 5px solid white;
  }
</style>