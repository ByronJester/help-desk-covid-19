<template>
	<div class="w-screen mt-10">
		<div class="flex flex-col">

			<div class="w-full flex flex-col md:flex-row">
				
				<div class="w-full flex justify-center items-center">
			    <graph-bar
            style="width: 100% !important"
            :height="400"
            :axis-min="0"
            :axis-max="status.num"
            :labels="[ 'COVID 19 Total Case' ]"
            :names="status.names"
            :values="[
							[records.recovered],
							[records.death],
							[records.quarantine]
						]">
			        <note :text="'BAR CHART BASE ON COVID 19 STATUS'"></note>
			        <tooltip :names="status.names" :position="'left'"></tooltip>
			        <legends :names="status.names" :filter="true"></legends>
			    </graph-bar>

				</div>

				<div class="w-full flex justify-center items-center">
			    <graph-bar
            style="width: 100% !important"
            :height="400"
            :axis-min="0"
            :axis-max="gender.num"
            :labels="[ 'COVID 19 Total Case' ]"
            :names="gender.names"
            :values="[
							[records.male],
							[records.female]
						]">
			        <note :text="'BAR CHART BASE ON GENDER'"></note>
			        <tooltip :names="gender.names" :position="'left'"></tooltip>
			        <legends :names="gender.names" :filter="true"></legends>
			    </graph-bar>

				</div>

		  </div>
	  </div>
	</div> 
</template>

<script>
	
	export default {
		props: ['records'],
		data() {
			return {
				status: {
					names: [ 'Recovered', 'Death', 'Quarantine' ],
					num	 : 0
				},

				gender: {
					names: [ 'Male', 'Female' ],
					num	 : 0
				}
			}
			
		},

		mounted() {

			this.status.num = Math.max(this.records.recovered, this.records.death, this.records.quarantine)

			this.gender.num = Math.max(this.records.male, this.records.death, this.records.female)
		}
	}
</script>