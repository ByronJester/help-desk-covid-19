<template>
	<div class="w-screen">
		<div class="w-full font-bold text-4xl my-16">
			{{ title }}
		</div>
		<table
      class="w-full"
    >
      <thead>
        <tr class="border border-black bg-blue-900 text-white uppercase text-sm whitespace-pre-wrap">
          <th class="py-3 px-6 text-center" v-for="field in fields"> {{ field }}</th>
        </tr>
      </thead>

      <tbody class="text-gray-600 text-sm font-light">
        <tr
          class="border border-black hover:bg-gray-200 cursor-pointer"
          v-for="(l, index) in list"
          :key="index"
          @click="getSelected(l)"
        >
          <td class="py-3 px-6  whitespace-pre-wrap text-center" v-for="key in keys">
            <div class="flex items-center justify-center" v-if="!key.slot">
              <span class="font-medium">{{list[index][key.label]}}</span>
            </div>

            <div class="flex items-center justify-center" v-else>
              <slot :name="key.slot_name" :arg="list[index][key.label]"/>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

	</div>
</template>

<script>

	export default {
		props: ['fields', 'keys', 'list', 'title', 'selected'],
		components: {
			
		},

		data() {
			return {

			}
		},

		mounted() {
		},

		methods: {
			getSelected(arg) {
				this.$emit('update:selected', arg)
			}
		}
	}
</script>

<style scoped>

</style>