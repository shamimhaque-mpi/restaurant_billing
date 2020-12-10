<template>
    <div>
        <div class="form-row">
            <div class="col-md-3">
                <select v-model="category_id" class="form-control" @change="getCatgoryProduct">
                    <option disabled value=""> {{ select_category }} </option>
                    <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <select v-model="product" class="form-control">
                    <option disabled value="">{{ select_product }}</option>
                    <option v-for="product_data in products" :value="product_data">{{ product_data.title }}</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-info" v-if="product" @click="addNewSale"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <br>
        <form v-on:submit.prevent>
            <div class="form-row">
                <div class="col-md-3">
                    <label><strong>{{ customer_name_field }} <span class="text-danger">*</span></strong></label>
                    <input type="text" class="form-control" title="name" v-model="customer_name" required>
                </div>
                <div class="col-md-3">
                    <label><strong>{{ customer_mobile_field }} <span class="text-danger">*</span> </strong></label>
                    <input type="text" class="form-control" title="mobile" v-model="customer_mobile" required>
                </div>
            </div>

            <br>
            <div>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <th width="55">{{ sl }}</th>
                    <th width="100">{{ photo }}</th>
                    <th>{{ name }}</th>
                    <th width="10%">{{ quantity }}</th>
                    <th width="15%">{{ price }}</th>
                    <th class="action">{{ action }}</th>
                    </thead>
                    <tbody>

                    <tr v-for="(bill, index) in getAllSale">
                        <td>{{ (index+1) }}</td>
                        <td>
                            <img :src=" url+'/'+bill.image" alt="">
                        </td>
                        <td>{{ bill.product_title }}</td>
                        <td>
                            <input type="number" v-model="bill.product_quantity"
                                   class="form-control" min=0 oninput="validity.valid||(value='')" @keyup="getPayableAmount()">
                        </td>
                        <td>{{ parseFloat(bill.product_price*bill.product_quantity).toFixed(2) }} ৳</td>
                        <td width="8%" class="text-center">
                            <button @click="deleteFromCart(bill.sale_product_id, index, bill.status)"
                                    class="btn text-white  btn-danger"><i
                                class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ total }} </th>
                        <th>{{ countQuantity() }}</th>
                        <th colspan="3">{{ countTotalPrice() }} ৳</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">{{ discount_field }} (%) </th>
                        <th colspan="2">
                            <input type="number" class="form-control" v-model="discount" min=0 max=100 oninput="validity.valid||(value='')" step="any" required>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">{{ payable_field }} </th>
                        <th colspan="2">
                            {{ payable_amount }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">{{ paid_field }} </th>
                        <th colspan="2">
                            <input type="number" class="form-control" v-model="given_money" min=1 oninput="validity.valid||(value='')" step="any" required>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">{{ return_field }} </th>
                        <th colspan="2">
                            {{ return_money }}
                        </th>
                    </tr>
                    </tbody>
                </table>
                <button @click="updateToSaleProduct" class="float-right btn btn-primary"><i
                    class="fa fa-check"></i> {{ submit }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "SaleEdit",
        props: [
            'id', 'submit', 'sl', 'photo', 'name', 'quantity', 'price', 'discount_field', 'total',
            'action', 'url', 'categories', 'customer_name_field', 'paid_field',
            'customer_mobile_field', 'total_field', 'select_category', 'select_product', 'after_discount', 'return_field', 'payable_field'
        ],
        data() {
            return {
                active: false,
                totalQty: 0.00,
                getAllSale: [],
                customer_name: '',
                customer_mobile: '',
                given_money: '',
                totalQty: 0,
                totalPrice: 0,
                category_id: '',
                product: '',
                products: [],
                sale_id: '',
                payable_amount: '',
                return_money: '',
                discount: ''
            }
        },
        mounted() {
            this.mySale();
        },
        watch: {
            discount: function(value){
                var total = parseFloat(this.countTotalPrice()).toFixed(2);
                total -= (parseFloat(value).toFixed(2) * total) / 100;
                this.payable_amount = total.toFixed(2);
            },
            given_money: function(value){
                var payable = parseFloat(this.payable_amount).toFixed(2);
                value = parseFloat(value).toFixed(2);
                if(value >= payable){
                    this.return_money = parseFloat(value - payable).toFixed(2);
                }
                else{
                    this.return_money = 0;
                }
            }
        },
        methods: {
            getCatgoryProduct: function () {
                axios.get(this.url + '/api/get-category-product/' + this.category_id)
                    .then((response) => {
                        this.product = '';
                        this.products = response.data.products;
                    })
                    .catch((exception) => {
                        console.log(exception);
                    });
            },
            addNewSale: function () {
                var increase_qty = true;
                this.getAllSale.forEach((sale) => {
                    if (sale.product_title == this.product.title) {
                        increase_qty = false;
                        sale.product_quantity += 1;
                        this.countTotalPrice();
                        this.getPayableAmount();
                    }
                });

                if (increase_qty) {
                    var saleObject = {
                        product_title: this.product.title,
                        image: this.product.image,
                        discount: this.product.discount,
                        product_quantity: 1,
                        product_price: (this.product.regular_sale_price - (this.product.regular_sale_price * this.product.discount) / 100),
                        product_id: this.product.id
                    };

                    this.getAllSale.push(saleObject);

                    this.getPayableAmount();
                }
            },
            mySale: function () {
                axios.get(this.url + '/admin/sale/get_single_sale/' + this.id)
                    .then((response) => {
                        this.getAllSale = response.data;
                        this.customer_mobile = response.data[0].customer_mobile;
                        this.customer_name = response.data[0].customer_name;
                        this.given_money = response.data[0].given_money;
                        this.sale_id = response.data[0].id;
                        this.discount = response.data[0].discount;
                        this.payable_amount = response.data[0].total_price_after_discount;
                        this.return_moeny = parseFloat(response.data[0].given_money - response.data[0].total_price_after_discount).toFixed(2);
                    })
                    .catch((exception) => {
                        console.log(exception);
                    });
            },
            deleteFromCart: function (id, index, status="") {
                swal("Are you sure?", {
                    title: "Warning!",
                    text: "Are you sure!",
                    dangerMode: true,
                    buttons: true,
                    icon: "warning"
                }).then((willDelete) => {
                    if (willDelete) {
                        if (status) {
                            axios.post(this.url + '/admin/sale/delete_from_sale', {
                                id: id
                            })
                                .then((response) => {
                                    toastr.error("Item has been deleted!");
                                    this.getAllSale.splice(index, 1);
                                    this.getPayableAmount();
                                })
                                .catch((exception) => {
                                    console.log(exception);
                                });
                        } else {
                            this.getAllSale.splice(index, 1);
                            this.getPayableAmount();
                        }
                    }
                });
            },
            getPayableAmount: function(){
                var total = parseFloat(this.countTotalPrice()).toFixed(2);
                console.log(total)
                var payable = total - (total * parseFloat(this.discount) / 100);
                console.log(payable)
                this.payable_amount = parseFloat(payable).toFixed(2);
            },
            countQuantity: function () {
                var totalQty = 0;
                this.getAllSale.forEach((sale) => {
                    totalQty = parseFloat(totalQty) + parseFloat(sale.product_quantity);
                });

                this.totalQty = totalQty;

                return totalQty;
            },
            countTotalPrice: function () {
                var totalPrice = 0;
                this.getAllSale.forEach((sale) => {
                    totalPrice = parseFloat(totalPrice) + (parseFloat(sale.product_price) * parseFloat(sale.product_quantity));
                });

                this.totalPrice = totalPrice;

                return parseFloat(totalPrice).toFixed(2);
            },
            updateToSaleProduct: function () {
                var total = parseFloat(this.payable_amount);
                var given_money = parseFloat(this.given_money);
                var payable_amount = parseFloat(this.payable_amount).toFixed(2);

                if(given_money >= total && payable_amount){
                    axios.post(this.url + '/admin/sale/update-to-sale-product', {
                        sale_id: this.sale_id,
                        customer_name: this.customer_name,
                        customer_mobile: this.customer_mobile,
                        given_money: this.given_money,
                        products: this.getAllSale,
                        totalQty: this.countQuantity(),
                        totalPrice: this.countTotalPrice(),
                        total_price_after_discount: this.payable_amount,
                        discount: this.discount,
                    })
                        .then((response) => {
                            window.location.href = this.url + "/admin/sale/view/" +this.sale_id;
                        })
                        .catch((exception) => {
                            console.log(exception);
                        });
                }else{
                    toastr.error("Paid must be greater than total!");
                }

            }
        }
    }
</script>
<style scoped>
    img {
        width: 80px;
        height: 80px;
    }

    .form-row {
        margin: 0;
    }
</style>
