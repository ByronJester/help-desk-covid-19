<template>
	<div class="screen">
   <!-- code -->
   <div class="innerdiv cursor-p">
      <img
	      :src="'/images/chat.png'"
	      class="h-16 w-20 md:h-24 md:w-32 cursor-pointer"
	      style="border-radius: 30%;"
	      alt=""
	      @click="imageClick"
	    />
   </div>
</div>
</template>

<script>
	export default {
		props: ['showChat'],
		methods: {
			imageClick(){
				this.$emit('update:showChat', true)
			}
		}
	}
</script>
<style scoped>

	.screen{
		position: relative;
	}
	.innerdiv {
		position: absolute;
		bottom: 0;
		right: 0;
	}
</style>