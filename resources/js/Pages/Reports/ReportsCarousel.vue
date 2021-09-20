<template>
	<div class="w-screen mt-8">
		<div class="flex flex-col">

			<div class="text-md text-3xl" v-if="path == '/reports/cases'"> Covid 19 Statistics </div>

			<div class="w-full flex flex-col md:flex-row" v-if="path == '/reports/cases'">
				<div class="w-full flex justify-center items-center">
			    <graph-bar
            style="width: 100% !important"
            :height="400"
            :axis-min="0"
            :axis-max="status.num"
            :labels="[ 'COVID 19 Total Case' ]"
            :colors="['#A0E7E5', '#FFAEBC', '#B4F8C8']"
            :names="status.names"
            :values="[
							[records.recovered],
							[records.death],
							[records.quarantine]
						]">
			        <note :text="'NO. OF COVID CASES BASE ON STATUS'"></note>
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
            :colors="['#A0E7E5', '#FFAEBC']"
            :names="gender.names"
            :values="[
							[records.male],
							[records.female]
						]">
			        <note :text="'NO. OF COVID CASES BASE ON GENDER'"></note>
			        <tooltip :names="gender.names" :position="'left'"></tooltip>
			        <legends :names="gender.names" :filter="true"></legends>
			    </graph-bar>
				</div>
		  </div>

		  <div class="text-md text-3xl" v-if="path == '/reports/vaccinations'"> Vaccination Statistics </div>

		  <div class="w-full mt-32" v-if="path == '/reports/vaccinations'">
				<graph-bar3d
	            style="width: 100% !important; margin-top: 10px !important" 
	            :height="600"
	            :axis-min="0"
	            :axis-max="vaccines.gender"
	            :padding-top="100"
	            :padding-bottom="100"
	            :depth="180"
	            :labels="vaccines.labels"
	            :names="['Male', 'Female']"
	            :colors="['#A0E7E5', '#FFAEBC']"
	            :values="[
	            	vaccines.male,
	            	vaccines.female
	            ]">
	        <note :text="'NO. OF VACCINATIONS BASE ON GENDER'"></note>
	        <tooltip :names="['Male', 'Female']" :position="'left'"></tooltip>
	        <legends :names="['Male', 'Female']"></legends>
	        <rotate3d></rotate3d>
	    	</graph-bar3d>

	    	<graph-bar3d
	            style="width: 100% !important; margin-top: 70px"
	            :height="600"
	            :axis-min="0"
	            :axis-max="vaccines.classificationA"
	            :padding-top="100"
	            :padding-bottom="100"
	            :depth="180"
	            :labels="vaccines.labels"
	            :names="['A1', 'A2', 'A3', 'A4', 'A5']"
	            :values="[
	            	vaccines.A1,
	            	vaccines.A2,
	            	vaccines.A3,
	            	vaccines.A4,
	            	vaccines.A5
	            ]">
	        <note :text="'NO. OF VACCINATIONS BASE ON CLASSIFICATION A'"></note>
	        <tooltip :names="['A1', 'A2', 'A3', 'A4', 'A5']" :position="'left'"></tooltip>
	        <legends :names="['A1', 'A2', 'A3', 'A4', 'A5']"></legends>
	        <rotate3d></rotate3d>
	    	</graph-bar3d>

	    	<graph-bar3d
	            style="width: 100% !important; margin-top: 70px"
	            :height="600"
	            :axis-min="0"
	            :axis-max="vaccines.classificationB"
	            :padding-top="100"
	            :padding-bottom="100"
	            :depth="180"
	            :labels="vaccines.labels"
	            :names="['B1', 'B2', 'B3', 'B4', 'B5', 'B6']"
	            :values="[
	            	vaccines.B1,
	            	vaccines.B2,
	            	vaccines.B3,
	            	vaccines.B4,
	            	vaccines.B5,
	            	vaccines.B6
	            ]">
	        <note :text="'NO. OF VACCINATIONS BASE ON CLASSIFICATION B'"></note>
	        <tooltip :names="['B1', 'B2', 'B3', 'B4', 'B5', 'B6']" :position="'left'"></tooltip>
	        <legends :names="['B1', 'B2', 'B3', 'B4', 'B5', 'B6']"></legends>
	        <rotate3d></rotate3d>
	    	</graph-bar3d>

	    	<graph-bar3d
	            style="width: 100% !important; margin-top: 70px"
	            :height="600"
	            :axis-min="0"
	            :axis-max="vaccines.classificationC"
	            :padding-top="100"
	            :padding-bottom="100"
	            :depth="180"
	            :labels="vaccines.labels"
	            :names="['C']"
	            :values="[
	            	vaccines.C,
	            ]">
	        <note :text="'NO. OF VACCINATIONS BASE ON CLASSIFICATION C'"></note>
	        <tooltip :names="['C']" :position="'left'"></tooltip>
	        <legends :names="['C']"></legends>
	        <rotate3d></rotate3d>
	    	</graph-bar3d>
			</div>


	  </div>
	</div> 
</template>

<script>
	
	export default {
		props: ['records', 'vaccinations', 'path'],
		data() {
			return {
				status: {
					names: [ 'Recovered', 'Death', 'Quarantine' ],
					num	 : 0
				},

				gender: {
					names: [ 'Male', 'Female' ],
					num	 : 0
				},

				vaccines:{
					labels: [],
					male: [],
					female: [],
					A1: [],
					A2: [],
					A3: [],
					A4: [],
					A5: [],
					B1: [],
					B2: [],
					B3: [],
					B4: [],
					B5: [],
					B6: [],
					C: 	[],

					classificationA: 0,
					classificationB: 0,
					classificationC: 0,
					gender: 0
				}
			}
			
		},

		mounted() {
			if(this.path == '/records/cases') {
				this.status.num = Math.max(this.records.recovered, this.records.death, this.records.quarantine)

				this.gender.num = Math.max(this.records.male, this.records.death, this.records.female)
			}

			if(this.path == '/reports/vaccinations') {
				for (let v = 0; v < this.vaccinations.length; v++) {
					this.vaccines.labels.push(this.vaccinations[v].name)
					this.vaccines.male.push(this.vaccinations[v].male)
					this.vaccines.female.push(this.vaccinations[v].female)
					this.vaccines.A1.push(this.vaccinations[v].A1)
					this.vaccines.A2.push(this.vaccinations[v].A2)
					this.vaccines.A3.push(this.vaccinations[v].A3)
					this.vaccines.A4.push(this.vaccinations[v].A4)
					this.vaccines.A5.push(this.vaccinations[v].A5)
					this.vaccines.B1.push(this.vaccinations[v].B1)
					this.vaccines.B2.push(this.vaccinations[v].B2)
					this.vaccines.B3.push(this.vaccinations[v].B3)
					this.vaccines.B4.push(this.vaccinations[v].B4)
					this.vaccines.B5.push(this.vaccinations[v].B5)
					this.vaccines.B6.push(this.vaccinations[v].B6)
					this.vaccines.C.push(this.vaccinations[v].C)
				}

				this.vaccines.gender = Math.max(Math.max(...this.vaccines.male), Math.max(...this.vaccines.female))
				this.vaccines.classificationA = Math.max(Math.max(...this.vaccines.A1), Math.max(...this.vaccines.A2), Math.max(...this.vaccines.A3), Math.max(...this.vaccines.A4), Math.max(...this.vaccines.A5))
				this.vaccines.classificationB = Math.max(Math.max(...this.vaccines.B1), Math.max(...this.vaccines.B2), Math.max(...this.vaccines.B3), Math.max(...this.vaccines.B4), Math.max(...this.vaccines.B5), Math.max(...this.vaccines.B6))
				this.vaccines.classificationC = Math.max(Math.max(...this.vaccines.C))
			}
		}
	}
</script>