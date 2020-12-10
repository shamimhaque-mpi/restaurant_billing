<template>
	<div v-cloak>
		<div class="pt-1">
			<div class="form-row">
				<div class="col-md-2 none">
					<input type="date" class="form-control" v-model="from_date">
				</div>
				<div class="col-md-2 none">
					<input type="date" class="form-control" v-model="to_date">
				</div>
				<div class="col-md-2 none">
					<select v-model="table_no" class="form-control">
                        <option value="" > -- Select Table -- </option>
                        <option :value="table.id" v-for="table in tables"> {{ table.name }} </option>
                    </select>
				</div>
				<div class="col-md-5 offset-md-1">
					<table class="table table-bordered">
						<tr class="td-padding">
							<td>
								<strong>{{ total_product }}:</strong>
							<td>
								<strong>{{ totalQty }}</strong>
							</td>
							<td>
								<strong>{{ total_sale }}:</strong>
							</td>
							<td>
								<strong>{{ totalPrice+' TK' }}</strong>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<br>

			<div class="form-row none">
				<div class="col-md-1">
					<select v-model="per_page_item" class="form-control">
						<option :value="20" :selected="per_page_item == 20">20</option>
						<option :value="50" :selected="per_page_item == 50">50</option>
						<option :value="100" :selected="per_page_item == 100">100</option>
						<option :value="500" :selected="per_page_item == 500">500</option>
						<option :value="1000" :selected="per_page_item == 1000">1000</option>
						<option :value="2000" :selected="per_page_item == 2000">2000</option>
					</select>
				</div>
			</div>

			<br>

			<table class="table table-bordered table-striped display">
				<thead>
					<th width="5%">{{ sl }}</th>
					<th width="10%">{{ sale_date }}</th>
					<th width="5%">{{ voucher }}</th>
					<th width="10%">{{ saler }}</th>
					<th width="10%">{{ table_no_th }}</th>
					<!-- <th>{{ customer_name }}</th> -->
					<!-- <th>{{ customer_mobile }}</th> -->
					<th width="5%">{{ quantity }}</th>
					<th width="10%">{{ total }}</th>
					<th width="10%">{{ discount }}</th>
					<th width="10%">{{ grand_total }}</th>
					<th width="5%">{{ due_th }}</th>
					<th width="5%">{{ status }}</th>
					<th width="15%" class="none">{{ action }}</th>
				</thead>

				<tbody>
					<tr v-for="(sale, sale_index) in sales">
						<td>{{ sale_index + 1 }}</td>
						<td>{{ getDateFormat(sale.created_at) }}</td>
						<td>{{ getVoucher(sale.id) }}</td>
						<td>{{ sale.saler }}</td>
						<td>{{ sale.table_name }}</td>
						<!--						<td>{{ sale.customer_name }}</td>-->
						<!--						<td>{{ sale.customer_mobile }}</td>-->
						<td>{{ +sale.total_product }}</td>
						<td>{{ parseFloat(sale.total_price).toFixed(2) }}</td>
						<td>{{ sale.discount ? parseFloat(sale.discount).toFixed(2) : 0 }}</td>
						<td>{{ sale.total_price_after_discount ? parseFloat(sale.total_price_after_discount).toFixed(2) : 0 }}</td>
						<td>{{ sale.total_due ? parseFloat(sale.total_due).toFixed(2) : 0 }}</td>
						<td>{{ sale.order == 1 ? "Order" : "Sale" }}</td>
						<td class="none">
							<span v-for="(permission, index) in permission_submenus">
								<a title="View" v-bind:href="gotoSale(sale.id)" class="btn btn-primary btn-sm" v-if="index == 0 && checkPermission(permission.id)" ><i class="fa fa-eye"></i></a>
								<!-- <button class="btn btn-info btn-sm" v-if="index == 1 && checkPermission(permission.id)" @click="gotoEdit(sale.id)"><i class="fa fa-edit"></i></button> -->
								<button title="Collect Due" class="btn btn-info btn-sm" v-if="index == 3 && checkPermission(permission.id) && sale.total_due > 0" @click="gotoCollectDue(sale.id)"><i class="fa fa-calendar"></i></button>
								<button title="Delete" class="btn btn-danger btn-sm" v-if="index == 2 && checkPermission(permission.id)" @click="gotoDelete(sale.id, sale_index)"><i class="fa fa-trash"></i></button>
							</span>
						</td>
					</tr>

					<tr>
						<th colspan="5" class="text-right">{{ final_total }}</th>
						<th>{{ getTotalQty() }}</th>
						<th colspan="2">{{ parseFloat(getTotalPrice()).toFixed(2)+' TK' }}</th>
						<th colspan="1">{{ parseFloat(getAfterDiscountPrice()).toFixed(2)+' TK' }}</th>
						<th colspan="4">{{ parseFloat(getTotalDue()).toFixed(2)+' TK' }}</th>
					</tr>
				</tbody>
			</table>

			<pagination
			v-if="pagination.last_page > 1"
			:pagination="pagination"
			:offset="5"
			@paginate="from_date === '' && to_date === '' ? allSale() : searchSale()"
			>
		</pagination>

	</div>
</div>
</template>

<script>
import swal from 'sweetalert';
import Detail from './Details';

export default {
	name: "AllSale",
	props: [
	'sl','saler', 'quantity', 'title', 'total', 'action', 'permission_submenus', 'in_body', 'url', 'final_total', 'sale_date', 'customer_name', 'grand_total', 'status',
	'total_sale', 'total_product', 'customer_mobile', 'voucher', 'discount', 'after_discount', 'price', 'table_no_th', 'due_th'
	],
	data(){
		return {
			sales: [],
			from_date: '',
			to_date: '',
			table_no: '',
			totalPrice: 0,
			totalQty: 0,
			per_page_item: 50,
			search: false,
            tables: [],
			pagination: {
				current_page: 1
			}
		}
	},
	mounted() {
		//this.deleteAllFromCart();
        axios.get(this.url + '/admin/sale/tables')
        .then((response) => {
            this.getTables(JSON.stringify(response.data))
        })
        .catch((exception) => {
            console.log(exception);
        });
		this.allSale();
		this.totalSale();
		this.totalSaleAmount();
	},
	methods: {
        getTables: function(responseData){
            this.tables = JSON.parse(responseData);
        },
		getDateFormat: function(original_date){
			var d = new Date(original_date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

			if (month.length < 2) month = '0' + month;
			if (day.length < 2) day = '0' + day;

			return [year, month, day].join('-');
		},
		totalSale: function(){
			axios.get(this.url+'/api/get-all-sale')
			.then((response) => {
				this.totalQty = parseFloat(response.data).toFixed(2);
			})
			.catch((exception) => {
				console.log(exception);
			});
		},
		totalSaleAmount: function(){
			axios.get(this.url+'/api/get-all-sale-amount')
			.then((response) => {
				this.totalPrice = parseFloat(response.data).toFixed(2);
			})
			.catch((exception) => {
				console.log(exception);
			});
		},
		allSale: function(){
			axios.get(this.url+'/api/sale/all/' + this.per_page_item + '?page='+ this.pagination.current_page)
			.then((response) => {
				this.sales = response.data.data;
				this.pagination = response.data.meta;
			})
			.catch((exception) => {
				console.log(exception)
			});
		},
		searchSale: function(){
			if(this.to_date && this.from_date && this.table_no){
				axios.get(this.url+'/api/sale/search/'+this.from_date+'/'+this.to_date + '/'+ this.table_no + '/' + this.per_page_item + "?page=" + this.pagination.current_page)
				.then((response) => {
					this.sales = response.data.data;
					this.pagination = response.data.meta;
				})
				.catch((exception) => {
					console.log(exception);
				});
			}
			else if(this.to_date && this.from_date){
				axios.get(this.url+'/api/sale/search/'+this.from_date+'/'+this.to_date + '/invalid/' + this.per_page_item + "?page=" + this.pagination.current_page)
				.then((response) => {
					this.sales = response.data.data;
					this.pagination = response.data.meta;
				})
				.catch((exception) => {
					console.log(exception);
				});
			}
			else if(this.table_no){
				axios.get(this.url+'/api/sale/search/'+'invalid/'+'invalid/'+ this.table_no + '/' + this.per_page_item + "?page=" + this.pagination.current_page)
				.then((response) => {
					this.sales = response.data.data;
					this.pagination = response.data.meta;
				})
				.catch((exception) => {
					console.log(exception);
				});
			}
			else{
				axios.get(this.url+'/api/sale/search/'+this.from_date+"/invalid/invalid/" + this.per_page_item + "?page=" + this.pagination.current_page)
				.then((response) => {
					this.sales = response.data.data;
					this.pagination = response.data.meta;
				})
				.catch((exception) => {
					console.log(exception);
				});
			}
		},
		getVoucher: function(sale_id){
			var voucher = sale_id;
			var sale_id_length = sale_id.toString().length;

			if(sale_id_length < 2){
				voucher = "00000"+voucher;
			}
			else if(sale_id_length < 3){
				voucher = "0000"+voucher;
			}
			else if(sale_id_length < 4){
				voucher = "000"+voucher;
			}
			else if(sale_id_length < 5){
				voucher = "00"+voucher;
			}
			else if(sale_id_length < 6){
				voucher = "0"+voucher;
			}
			return voucher;
		},
		checkPermission: function(menu_id){
			return this.in_body.includes(""+menu_id+"");
		},
		gotoSale: function(sale_id){
			return this.url+'/admin/sale/view/'+sale_id;
		},
		gotoEdit: function(sale_id){
			window.location.href = this.url+"/admin/sale/edit/"+sale_id;
		},
		gotoCollectDue: function(sale_id){
			window.location.href = this.url+"/admin/due/collect/"+sale_id;
		},
		gotoDelete: function(sale_id, index){
			swal("Are you sure?", {
				title: "Warning!",
				text: "Are you sure!",
				dangerMode: true,
				buttons: true,
				icon: "warning"
			}).then((willDelete) => {
				if (willDelete) {
					axios.post(this.url+'/api/sale/delete', {
						sale_id: sale_id
					})
					.then((response) => {
						this.sales.splice(index, 1);
						toastr.success("Deleted Successfully");
					})
					.catch((exception) => {
						console.log(exception);
					})
					
				}
			});
		},
		getTotalQty: function(){
			var total = 0;
			this.sales.forEach((sale) => {
				total += parseFloat(sale.total_product)
			});
			return total;
		},
		getTotalPrice: function(){
			var total = 0;
			this.sales.forEach((sale) => {
				total += parseFloat(sale.total_price)
			});
			return total;
		},
		getTotalDue: function(){
			var total = 0;
			this.sales.forEach((sale) => {
				total += parseFloat(sale.total_due)
			});
			return total;
		},
		getAfterDiscountPrice: function(){
			var total = 0;
			this.sales.forEach((sale) => {
				total += parseFloat(sale.total_price_after_discount);
			});
			return total;
		}
	},
	computed: {

	},
	watch: {
		from_date: function(){
			this.searchSale();
		},
		to_date: function(){
			this.searchSale();
		},
		table_no: function(){
			this.searchSale();
		},
		per_page_item: function(value){
			if(this.to_date || this.from_date){
				this.searchSale();
			}
			else{
				this.allSale();
			}
		}
	},
	components: {
		Detail
	}
}
</script>
<style>
.td-padding td{
	padding: 0.55rem;
}
</style>
