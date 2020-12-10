<template>
	<div>
		
	</div>
</template>

<script>
export default {
	name: "Details",
	props: ['id', 'url'],
	data(){
		return{
			sales: []
		}
	},
	methods: {
		loadData: function(){
			axios.get(this.url+'/api/sale/get/'+this.id)
			.then((response) => {
				this.sales = response.data.sale;
			})
			.catch((exception) => {
				console.log(exception);
			});
		}
	},
	mounted() {
		
	}
}
</script>
