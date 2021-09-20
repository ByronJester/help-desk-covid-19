<template>
	<div class="w-full">
		<div class="w-full my-16">
			<span class="font-bold text-xl md:text-4xl"> {{ title }} </span> 
      <span class="float-right w-3/6 md:w-1/5">
        <input type="type" v-model="form.search" @input="initiateSearch()" placeholder="Search" class="border border-green-200 px-3 py-1 md:py-4 w-full"/>
      </span>
		</div>
		<table
      class="w-full"
    >
      <thead>
        <tr class="border border-black bg-blue-900 text-white uppercase text-xs md:text-sm whitespace-pre-wrap">
          <th class="py-3 px-1 md:px-6 text-center" v-for="field in fields"> {{ field }}</th>
        </tr>
      </thead>

      <tbody class="text-black text-xs md:text-sm font-light">
        <tr
          class="border border-black hover:bg-gray-200 cursor-pointer"
          v-for="(l, index) in list"
          :key="index"
          @click="getSelected(l)"
        >
          <td class="py-3 px-1 md:px-6  whitespace-pre-wrap text-center" v-for="key in keys">
            <div class="flex items-center justify-center " v-if="!key.slot">
              <span>{{list[index][key.label]}}</span>
            </div>

            <div class="flex items-center justify-center" v-else>
              <slot :name="key.slot_name" :arg="list[index][key.label]"/>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="w-full">
      <span class="text-xs md:text-sm font-bold text-green-500">Page {{page}} of {{count}}</span>
    </div>

    <div class="w-fullr flex justify-center items-center my-5">
      <button class="mx-2 text-green-600" @click="prev()">
        <i class="fa fa-chevron-left fa-lg"></i>
      </button>

      <span class="text-base md:text-3xl mx-2 font-bold">
        {{page}}
      </span>

      <button class="mx-2 text-green-600" @click="next()">
        <i class="fa fa-chevron-right fa-lg"></i>
      </button>
    </div>

	</div>
</template>

<script>

	export default {
		props: ['fields', 'keys', 'list', 'selected', 'title', 'search', 'page', 'count'],
		components: {
			
		},

		data() {
			return {
        form: {
          search: null
        },
        timeOut: null
			}
		},

		mounted() {
      this.form.search = this.search
		},

		methods: {
			getSelected(arg) {
				this.$emit('update:selected', arg)
			},

      prev(){
        if(this.page <= 1) return;

        this.$emit('update:page', this.page - 1)
      },

      next(){
        if(this.page >= this.count) return;

        this.$emit('update:page', this.page + 1)
      },

      initiateSearch() {
        var self = this

        clearTimeout(this.timeOut);

        this.timeOut = setTimeout(
          function(){
            self.$emit('update:search', self.form.search)
          }
        , 2000);
      }
		},

    watch : {
      'form.search': function (arg) {
        
        // this.initiateSearch()

      }
    }
	}
</script>

<style scoped>

</style>