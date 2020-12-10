<template>
    <div v-cloak>
        <div v-if="active != true">
            <select v-model="table_no" class="form-control">
                <option :value="0" > --- Select Table Number --- </option>
                <option :value="table.id" v-for="table in tables"> {{ table.name }} </option>
            </select>
        </div>
        <div v-if="active">
            <div>
                <table class="table table-bordered table-hover display">
                    <thead>
                        <th width="15%">{{ sl }}</th>
                        <th>{{ name }}</th>
                        <th width="15%">Price </th>
                        <th width="15%">{{ quantity }} </th>
                        <th width="10%">{{ total }}</th>
                        <th class="action">{{ action }}</th>
                    </thead>
                    <tbody>

                        <tr v-for="(bill, index, sl) in carts">
                            <td width="8%" class="td_custom_padding">{{ (sl+1) }}</td>
                            <td width="54%" class="td_custom_padding">{{ bill.name }}</td>
                            <td width="15%" class="td_custom_padding text-center"><input type="text" name="price" @keyup="updateProduct(bill.id, bill.price, index)" v-model="bill.price" style="width: 44px; padding: 0 3px;"></td>
                            <td width="15%" class="td_custom_padding">
                                <div class="d-flex justify-content-center">
                                    <button class="" @click="minusQty(bill.qty, index, sl)">-</button>
                                    <input type="number" v-model="+bill.qty" @keyup="updateQty(bill.qty, index, sl)" min=0 oninput="validity.valid||(value='')" step="any" style="padding: 0px 3px; width: 35px; margin: 0 -1px;text-align: center;">
                                    <button class="" @click="plusQty(bill.qty, index, sl)">+</button>
                                </div>
                            </td>
                            <td class="td_custom_padding">{{ (parseFloat(bill.qty)*parseFloat(bill.price)).toFixed(2) }}TK</td>
                            <td width="8%" class="text-center td_custom_padding">
                                <button @click="deleteFromCart(bill.rowId, sl)" class="btn text-white  btn-danger btn-sm" style="line-height: 1.5px;"><i
                                    class="fa fa-close"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right td_custom_padding">{{ total }} </th>
                            <th class="td_custom_padding">{{ getTotalQty }}</th>
                            <th colspan="3" class="td_custom_padding">{{ parseFloat(getGrandTotal).toFixed(2) }}TK</th>
                        </tr>
                        <!-- ======================================================================= -->
                        <tr>

                            <td class="d-none" style="white-space: nowrap;" >
                                <div style="display: flex; align-items: center;">
                                    <label for="" class="d-flex align-items-center m-0">
                                        <input type="checkbox" v-model="is_order" oninput="validity.valid||(value='')" class="mr-1">
                                        <span>{{ is_order_field }}</span>
                                    </label>
                                </div>
                            </td> 

                            <td v-if="is_order == false" colspan="2">
                                <select v-model="table_no" class="form-control">
                                    <option :value="0" > --- Select Table Number --- </option>
                                    <option :value="table.id" v-for="table in tables"> {{ table.name }} </option>
                                </select>
                            </td>

                            <th colspan="2"  v-if="is_order == false">
                                <input type="text" class="form-control" title="name" v-model="customer_name" :placeholder="[[ customer_name_field ]]" required>
                            </th>
                            <th colspan="2"  v-if="is_order == false">
                                <input type="tex" class="form-control" title="mobile" :placeholder="[[ customer_mobile_field ]]" v-model="mobile" required>
                            </th>

                        </tr>
                        <!-- ======================================================================= -->
                        <tr>
                            <th class="text-right" style="white-space: nowrap;">{{ discount_field }} (%)</th>
                            <th colspan="2">
                                <input type="number" class="form-control" v-model="discount_2" min=0 max=100 step="1" oninput="if(this.value.length == 0) this.value=0">
                            </th>

                            <th class="text-right" style="white-space: nowrap;">{{ discount_field }} (TK)</th>
                            <th colspan="2">
                                <input type="number" class="form-control" v-model="discount" min=0 oninput="if(this.value.length == 0) this.value=0">
                            </th>
                        </tr>
                        <tr>
                            <th colspan="1" class="text-right">{{ vat_field }} (%) </th>
                            <th colspan="2">
                                <input type="number" class="form-control" v-model="vat" min=0 max=100 step=".1" oninput="if(this.value.length == 0) this.value=0">
                            </th>

                            <th colspan="1" class="text-right">{{ payable_field }} </th>
                            <th colspan="2">
                                {{ parseFloat(payable_amount).toFixed(2) }}
                            </th>
                        </tr>
                        <tr>

                            <th colspan="1" class="text-right"> Due </th>
                            <th colspan="2">
                                 {{ due }}
                            </th>

                            <th colspan="1" class="text-right">{{ paid_field }} </th>
                            <th colspan="2">
                                <input type="number" class="form-control" v-model="given_money" min=1 oninput="validity.valid||(value='')" required>
                            </th>
                        </tr>
                        <tr>

                            <th colspan="3" class="text-right"></th>
                            <th colspan="1" class="text-right">{{ return_field }} </th>
                            <th colspan="2">
                                {{ parseFloat(return_money).toFixed(2) }}
                            </th>
                        </tr>
                    </tbody>
                </table>
                <button @click="addToSaleProduct" class="float-right btn btn-primary"><i
                    class="fa fa-check"></i> {{ submit }}
                </button>
            </div>
        </div>
        <div v-else>
            <h4 class="text-center py-5 alert-warning br-4">{{ no_data }}</h4>
        </div>
    </div>
</template>

<script>
export default {
    name: "Bill",
    props: [
    'submit', 'sl', 'photo', 'name', 'quantity', 'price', 'is_order_field', 'discount_field', 'vat_field', 'discount_2_field', 'total', 'action', 'url', 'customer_name_field',
    'paid_field', 'customer_mobile_field','no_data', 'after_discount', 'after_vat', 'return_field', 'payable_field'
    ],
    data() {
        return {
            active: false,
            totalQty: 0.00,
            customer_name: '',
            mobile: '',
            given_money: '',
            return_money: 0,
            is_order: false,
            discount: 0,
            discount_2: 0,
            vat: 0,
            carts: [],
            tables: [],
            payable_amount: 0,
            table_no: 0,
            due: 0,
        }
    },
    computed: {
        getTotalQty: function () {
            return this.$store.getters.getTotalQty;
        },
        getGrandTotal: function () {
            this.getPayableAmount();
            return this.getGrandTotalFromMethod();
        }
    },
    mounted() {
        //this.deleteAllFromCart();
        this.getPayableAmount();
        axios.get(this.url + '/admin/sale/tables')
        .then((response) => {
            this.getTables(JSON.stringify(response.data))
        })
        .catch((exception) => {
            console.log(exception);
        });
    },
    methods: {
        getTables: function(responseData){
            this.tables = JSON.parse(responseData);
        },
        plusQty: function (qty, index, sl){
            var qty = qty + 1;
            var new_qty = qty;
            this.carts[index].qty = new_qty;
            this.updateQty(new_qty, index, sl);
        },
        minusQty: function (qty, index, sl){
            if(qty > 1){
                var qty = qty - 1;
                var new_qty = qty;
                this.carts[index].qty = new_qty;
                this.updateQty(new_qty, index, sl);
            }
        },
        updateQty: function (qty, index, sl) {
            if (qty > 0) {
                axios.post(this.url + '/admin/sale/update_cart_qty/'+this.table_no, {
                    rowId: index,
                    qty: qty
                })
                .then((response) => {
                    this.$store.commit('setCartiem', {
                        cartItem: response.data.cart // payload
                    });

                    this.$store.commit('setTotalQty', {
                        totalQty: response.data.count
                    });

                    this.$store.commit('setGrandTotal', {
                        grandTotal: response.data.total
                    });

                    this.getPayableAmount();
                })
                .catch((exception) => {
                    console.log(exception);
                });
                console.log(index);
            }
            else{
                this.getGrandTotalFromMethod();
                this.getPayableAmount();

                return 1;
            }

        },
        updateProduct:function(product_id, price, index)
        {
            axios.post(this.url + '/admin/sale/update_cart_price', {
                    rowId: index,
                    price: price
                })
                .then((response) => {
                    console.log(response.data);
                    this.$store.commit('setCartiem', {
                        cartItem: response.data.cart // payload
                    });

                    this.$store.commit('setTotalQty', {
                        totalQty: response.data.count
                    });

                    this.$store.commit('setGrandTotal', {
                        grandTotal: response.data.total
                    });

                    this.getPayableAmount();
                })
                .catch((exception) => {
                    console.log(exception);
                });
                console.log(index);
            // console.log(product_id, price);
        },
        deleteFromCart: function (cartRowId) {
            swal("Are you sure?", {
                title: "Warning!",
                text: "Are you sure!",
                dangerMode: true,
                buttons: true,
                icon: "warning"
            }).then((willDelete) => {
                if (willDelete) {
                    axios.post(this.url + '/admin/sale/delete-from-cart/'+this.table_no, {
                        rowId: cartRowId
                    })
                    .then((response) => {
                        console.log(response.data);
                        toastr.error("Item has been deleted!");
                        this.$store.commit('setCartiem', {
                                    cartItem: response.data.cart // payload
                                });

                        this.$store.commit('setTotalQty', {
                            totalQty: response.data.count
                        });

                        this.$store.commit('setGrandTotal', {
                            grandTotal: response.data.total
                        });

                        this.getPayableAmount();

                        if (response.data.count < 1) {
                            this.active = false;
                            this.mobile = '';
                            this.customer_name = '';
                        }
                        else{
                            this.active = true;
                            // this.carts = response.data.cart;
                            // Extracting the correct information
                            let i = 1;
                            let reposeOb = [];
                            let responseCartData = response.data.cart;
                            for(let cart in responseCartData){
                                if(responseCartData[cart].table == this.table_no){
                                    reposeOb[cart] = responseCartData[cart];
                                    if(responseCartData[cart].customer_name){
                                        this.customer_name = responseCartData[cart].customer_name
                                    }
                                    if(responseCartData[cart].customer_mobile){
                                        this.mobile = responseCartData[cart].customer_mobile
                                    }
                                }
                            }
                            this.carts = Object.assign({},reposeOb);
                        }    

                    })
                    .catch((exception) => {
                        console.log(exception);
                    });
                }
            });
        },
        deleteAllFromCart: function () {
            axios.get(this.url + '/admin/sale/allItemDelete')
            .then((response) => {
                toastr.error("All Item(s) has been deleted!");
                this.$store.commit('setCartiem', {
                            cartItem: '0'
                        });

                this.$store.commit('setTotalQty', {
                    totalQty: '0'
                });

                this.$store.commit('setGrandTotal', {
                    grandTotal: '0'
                });

                this.getPayableAmount();

                this.active = false;

            })
            .catch((exception) => {
                console.log(exception);
            });

        },
        addToSaleProduct: function () {
            if(this.$store.state.table_no > 0){
                var total = parseFloat(this.getGrandTotalFromMethod());
                total = total - parseFloat(this.discount) - (parseFloat(this.discount_2) * total) / 100 + (parseFloat(this.vat) * total) / 100;
                var payable_amount = parseFloat(this.payable_amount).toFixed(2);
                if (this.table_no != 0) {
                    axios.post(this.url + '/admin/sale/add-to-sale-product', {
                        customer_name: this.customer_name,
                        customer_mobile: this.mobile,
                        given_money: this.given_money,
                        is_order: this.is_order,
                        discount: this.discount,
                        discount_2: this.discount_2,
                        vat: this.vat,
                        total_after_discount: this.payable_amount,
                        total_due: this.due,
                        table_no: this.table_no
                    })
                    .then((response) => {
                        window.location.href = this.url + "/admin/sale/view/" + response.data.id;
                    })
                    .catch((exception) => {
                        console.log(exception);
                    });
                }
                else{
                    toastr.error("The table is mandatory... please select a table!");
                }
            }
            else{
                toastr.warning("Atfirst select a table");
            }
        },
        getGrandTotalFromMethod: function () {
            return this.$store.getters.getGrandTotal;
        },
        allCartData: function(){
            axios.get(this.url + '/admin/sale/all-cart-item/'+this.table_no)
            .then((response) => {
                if (response.data.count > 0) {

                    this.active = true;

                    this.$store.commit('setCartiem', {
                        cartItem: response.data.cart // payload
                    });

                    this.$store.commit('setTotalQty', {
                        totalQty: response.data.count
                    });

                    this.$store.commit('setGrandTotal', {
                        grandTotal: response.data.total
                    });

                    this.getPayableAmount();

                    if(response.data.count > 0){
                        this.active = true;
                        // Extracting the correct information
                        let i = 1;
                        let reposeOb = [];
                        let responseCartData = response.data.cart;
                        for(let cart in responseCartData){
                            if(responseCartData[cart].table == this.table_no){
                                reposeOb[cart] = responseCartData[cart];
                                if(responseCartData[cart].customer_name){
                                    this.customer_name = responseCartData[cart].customer_name
                                }
                                if(responseCartData[cart].customer_mobile){
                                    this.mobile = responseCartData[cart].customer_mobile
                                }
                            }
                        }
                        this.carts = Object.assign({},reposeOb);
                    }
                    else{
                        this.active = false;
                        this.mobile = '';
                        this.customer_mobile = '';
                    }     
                }
            })
            .catch((exception) => {
                console.log(exception);
            });
        },
        loadNewData: function(){
            this.allCartData();
        },
        getPayableAmount: function(){

            var total = this.getGrandTotalFromMethod();
            var payable = total - parseFloat(this.discount) - (parseFloat(this.discount_2) * total) / 100 + (parseFloat(this.vat) * total) / 100;

            this.payable_amount = parseFloat(payable).toFixed(2);
            let return_money = parseFloat(this.given_money - total).toFixed(2);

            let due = parseFloat(payable - this.return_money - this.given_money ).toFixed(2);
            if(this.return_money >= 0 && due >= 0){
                this.due = due;
                this.return_money = 0;
            }
        }
    },
    watch: {
        customer_name:function(){
            this.$store.state.customer_name = this.customer_name;
        },
        mobile:function(){
            this.$store.state.mobile = this.mobile;
        },
        table_no:function(){
            this.$store.state.table_no = this.table_no;
            // Cart Item
            axios.get(this.url + '/admin/sale/all-cart-item/'+this.table_no)
            .then((response) => {
                // if (response.data.count > 0) {

                    this.active = true;

                    this.$store.commit('setCartiem', {
                        cartItem: response.data.cart // payload
                    });

                    this.$store.commit('setTotalQty', {
                        totalQty: response.data.count
                    });

                    this.$store.commit('setGrandTotal', {
                        grandTotal: response.data.total
                    });

                    this.getPayableAmount();

                    if(response.data.count > 0){
                        this.active = true;
                        // Extracting the correct information
                        let i = 1;
                        let reposeOb = [];
                        let responseCartData = response.data.cart;
                        for(let cart in responseCartData){
                            if(responseCartData[cart].table == this.table_no){
                                reposeOb[cart] = responseCartData[cart];
                                if(responseCartData[cart].customer_name){
                                    this.customer_name = responseCartData[cart].customer_name
                                }
                                if(responseCartData[cart].customer_mobile){
                                    this.mobile = responseCartData[cart].customer_mobile
                                }
                            }
                        }
                        this.carts = Object.assign({},reposeOb);
                    }
                    else{
                        this.active = false;
                        this.mobile = '';
                        this.customer_name = '';
                    }     
                // }
            })
            .catch((exception) => {
                console.log(exception);
            });

        },
        given_money: function(value){
            var total = parseFloat(this.getGrandTotalFromMethod());
            total = total - parseFloat(this.discount) - (parseFloat(this.discount_2) * total) / 100 + (parseFloat(this.vat) * total) / 100;
            if(parseFloat(value) >= total){
                this.return_money = parseFloat(this.given_money - total).toFixed(2);
                this.due = 0;
            }
            else{
                this.return_money = 0;
                this.due = parseFloat(total - this.given_money).toFixed(2);
            }
        },
        discount: function(value){
            if(value > 0){
                var total = parseFloat(this.getGrandTotalFromMethod());
                total -= parseFloat(value);
                this.getPayableAmount();
                this.return_money = (parseFloat(this.given_money - total).toFixed(2) > 0 ? parseFloat(this.given_money - total).toFixed(2) : 0);
            }
        },
        discount_2: function(value){
            if(value <= 100){
                var total = parseFloat(this.getGrandTotalFromMethod());
                total -= parseFloat(value);
                this.getPayableAmount();
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
    .btn-small .btn .icon, .btn .fa {
        font-size: 10px !important;
        margin-right: 0 !important;
    }
    .btn-plus-minus {
        position: relative;
    }
    .btn-small{
        position: absolute;
        height:18px;
        right: 21px;
        line-height: 8px;
        padding: 0 9px;
    }
    .btn-small-success{
        top: 15px;
    }
    .btn-small-danger{
        bottom: 15px;
    }
    .td_custom_padding{
        padding: 2px 7px;
    }
</style>
