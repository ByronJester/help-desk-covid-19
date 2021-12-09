<template>
  <div class="w-screen">
   <nav class="relative flex flex-wrap items-center justify-start px-2 py-3 bg-green-800 mb-3">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-start">
      <div class="w-full relative flex lg:w-auto  px-4 lg:static lg:block">
        <a class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white cursor-pointer" @click="changeActive('/home')">
          <span>
            <img
              :src="'/images/logo.jpg'"
              class="h-16 w-20 md:h-24 md:w-32"
              style="border-radius: 50%;"
              alt="" 
            />
          </span>
        </a>
        <button class="mx-auto cursor-pointer text-xl px-3 py-1 border border-solid border-transparent rounded bg-transparent block md:hidden outline-none fVocus:outline-none" type="button" @click="showNav()">
          <span class="block relative w-6 h-px rounded-sm bg-white"></span>
          <span class="block relative w-6 h-px rounded-sm bg-white mt-1"></span>
          <span class="block relative w-6 h-px rounded-sm bg-white mt-1"></span>

        </button>
      </div>

      <div class="md:flex flex-grow block md:hidden" id="example-navbar-warning" v-if="!!is_collapse">
        <ul class="flex flex-col lg:flex-row list-none ml-auto text-base md:text-lg">

          <li class="nav-item mx-5" :class="{'--active' : active == '/home'}">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer" @click="changeActive('/home')">
              <i class="fa fa-home"></i> <span class="ml-2" >Home</span>
            </a>
          </li>

          <li class="nav-item mx-5" :class="{'--active' : active == '/news'}" v-if="user">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer" @click="changeActive('/news')">
              <i class="fa fa-tv"></i><span class="ml-2">Bayan Pantrol</span> 
            </a>
          </li>

          <li class="nav-item mx-5" :class="{'--active' : active == '/reports/cases' || active == '/reports/pending-vaccination' || active == '/reports/finish-vaccination'}" > 
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-file"></i><span class="ml-2">Reports</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/cases')"
                  >
                    <span class="ml-2 cursor-pointer">Covid 19</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/pending-vaccination')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccination Approval List</span>
                  </a>
                </li>

                <!-- <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/finish-vaccination')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinated List</span>
                  </a>
                </li> -->

              </ul>
            </div>
          </li>

          <li class="nav-item mx-5" :class="{'--active' : active == '/reports/vaccinations' || active == '/reports/vaccinations-information' || active == '/reports/vaccinations-classification'}" > 
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-file"></i><span class="ml-2">Vaccinations</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">
                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/vaccinations')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinations Request Form</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/vaccinations-information')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinne Benefits & Side Effect</span>
                  </a>
                </li>

    <!--             <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/vaccinations-classification')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinations Priority</span>
                  </a>
                </li> -->

              </ul>
            </div>
          </li>


          <li v-if="isAuthorize('admin', user)" class="nav-item mx-5" :class="{'--active' : active == '/users' || active == '/vaccinations' || active == '/virus-cases'}" > 
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-users"></i><span class="ml-2">Maintenance</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">

                <li v-if="isAuthorize('covid', user)">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/virus-cases')"
                  >
                    <span class="ml-2 cursor-pointer">Covid 19</span>
                  </a>
                </li>

                <li v-if="isAuthorize('vaccination', user)">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/vaccinations')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinations</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/contact-tracing')"
                  >
                    <span class="ml-2 cursor-pointer">Contact Tracing</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                   @click="changeActive('/users')">
                    <span class="ml-2 cursor-pointer">Users</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item mx-5" v-if="!user">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"@click="$emit('update:openModal', true)">
              <i class="fa fa-user-circle"></i><span class="ml-2">Sign in</span>
            </a>
          </li>

          <li class="nav-item mx-5" v-if="!!user">
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-user-circle"></i><span class="ml-2">{{ user.first_name}}</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">
                <li class="">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Profile</a>
                </li>

                <li class="">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" @click="logout()">Logout</a>
                </li>
                
              </ul>
            </div>
          </li>
        </ul>
      </div>

      <div class="md:flex flex-grow hidden md:block" id="example-navbar-warning">
        <ul class="flex flex-col lg:flex-row list-none ml-auto text-base md:text-lg">

          <li class="nav-item mx-5" :class="{'--active' : active == '/home'}">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"  @click="changeActive('/home')">
              <i class="fa fa-home"></i> <span class="ml-2" >Home</span>
            </a>
          </li>

          <li class="nav-item mx-5" :class="{'--active' : active == '/news'}" v-if="user">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer" @click="changeActive('/news')">
              <i class="fa fa-tv"></i><span class="ml-2">Bayan Patrol</span>
            </a>
          </li>

          <li class="nav-item mx-5" :class="{'--active' : active == '/reports/cases' || active == '/reports/pending-vaccination' || active == '/reports/finish-vaccination'}" > 
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-file"></i><span class="ml-2">Reports</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/cases')"
                  >
                    <span class="ml-2 cursor-pointer">Covid 19</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/pending-vaccination')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccination Approval List</span>
                  </a>
                </li>

                <!-- <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/finish-vaccination')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinated List</span>
                  </a>
                </li> -->

              </ul>
            </div>
          </li>

          <li class="nav-item mx-5" :class="{'--active' : active == '/reports/vaccinations' || active == '/reports/vaccinations-information' || active == '/reports/vaccinations-classification'}" > 
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-file"></i><span class="ml-2">Vaccinations</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">
                 <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/vaccinations')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinations Request Form</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/vaccinations-information')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinne Benefits & Side Effect</span>
                  </a>
                </li>

                <!-- <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/reports/vaccinations-classification')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinations Priority</span>
                  </a>
                </li> -->

              </ul>
            </div>
          </li>

          <li v-if="isAuthorize('admin', user)" class="nav-item mx-5" :class="{'--active' : active == '/users' || active == '/vaccinations' || active == '/virus-cases'}">
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-users"></i><span class="ml-2">Maintenance</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">
                
                <li v-if="isAuthorize('covid', user)">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/virus-cases')"
                  >
                    <span class="ml-2 cursor-pointer">Covid 19</span>
                  </a>
                </li>

                <li v-if="isAuthorize('vaccination', user)">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/vaccinations')"
                  >
                    <span class="ml-2 cursor-pointer">Vaccinations</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/contact-tracing')"
                  >
                    <span class="ml-2 cursor-pointer">Contact Tracing</span>
                  </a>
                </li>

                <li>
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                    @click="changeActive('/users')"
                  >
                    <span class="ml-2 cursor-pointer">Users</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item mx-5" v-if="!user">
            <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"@click="$emit('update:openModal', true)">
              <i class="fa fa-user-circle"></i><span class="ml-2">Sign in</span>
            </a>
          </li>

          <li class="nav-item mx-5" v-if="!!user">
            <div class="dropdown inline-block relative">
              <a class="px-3 py-2 flex items-center uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer">
                <i class="fa fa-user-circle"></i><span class="ml-2">{{ user.first_name}}</span>
              </a>

              <ul class="dropdown-menu absolute hidden pt-1">
                <li class="">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap cursor-pointer">Profile</a>
                </li>

                <li class="">
                  <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap cursor-pointer" @click="logout()">Logout</a>
                </li>
                
              </ul>
            </div>
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
        var req = {}

        if(arg == '/users') {
          req = {
            page: 1,
            search: ''
          }
        }

        if(arg == '/virus-cases') {
          req = {
            place: 1,
            page: 1,
            search: ''
          }
        }

        if(arg == '/vaccinations' || arg == '/reports/pending-vaccination' || arg == '/reports/finish-vaccination') {
          req = {
            place: 1,
            page: 1,
            search: ''
          }
        }

        Inertia.get(
          this.$root.route + arg, req,
          {
            onSuccess: () => { },
          },
        );
      },

      logout() {
        Inertia.post(this.$root.route + "/users/logout", {},
        {
          onSuccess: () => {

          }
        });
      },
    },


  }
</script>

<style scoped>
  .--active {
    border-bottom: 5px solid white;
  }

  .dropdown:hover .dropdown-menu {
    display: block;
    width: 300px;
    text-align: center;
  }
</style>