<template>
    <div v-cloak>
        <div id="scrol_button" class="alert-info br-2">
            <!-- <div class="container__"> -->
               <!-- <div class="inner" data-simplebar id="simplebar">
                    <div @click="categoryProduct(category.id)" class="floatLeft position-relative mx-1 active__" v-for="category in categories">
                        <img class="" :src="url+'/'+category.image" style="" alt="">
                        <figcaption class="category_name mt-1 position-absolute d-block"><strong>{{ category.title }}</strong></figcaption>
                    </div>
               </div> -->
                <a @click="categoryProduct(category.id)" class="active__ m-1 btn btn-theme text-white" v-for="category in categories" :src="url+'/'+category.image" style="" alt="">{{ category.title }}</strong></a>

            <!-- </div> -->
        </div>
        <hr class="border">
        <div class="row">
            <div id="product_list" class="col-lg-6 col-sm-12" data-simplebar style="max-height: 470px;">
                <div class="form-row product__container" v-cloak>
                    <div class="col-md-3 mb-3" v-for="(product, index) in products">
                        <div class="card" @click="addToSale(product)">
                            <div class="card-body text-center" style="padding: 12px;">
                                <img :src="url+'/'+product.image" style="width: 100px; height: 100px" alt="">
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <p class="mb-0" style="height: 42px; vertical-align: middle; display: block; overflow: hidden;">{{ product.title }} </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="mb-0">
                                            <strong class="text-success">
                                                {{ (product.regular_sale_price-(product.regular_sale_price*product.discount)/100).toFixed(2) }} TK
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <edit-bill
                :submit="submit"
                :sl="sl"
                :photo="photo"
                :name="name"
                :quantity="quantity"
                :price="price"
                :is_order_field="is_order"
                :discount_field="discount"
                :discount_2_field="discount_2"
                :vat_field="vat"
                :total="total"
                :customer_name_field="customer_name_field"
                :paid_field="paid_field"
                :customer_mobile_field="customer_mobile_field"
                :no_data="no_data"
                :action="action"
                :url="url"
                :after_discount="after_discount"
                :after_vat="after_vat"
                :return_field="return_field"
                :payable_field="payable_field"
                :table_no_old="table_no_old"
                ref="childComponent"
                ></edit-bill>
            </div>
        </div>
    </div>
</template>

<script>
import VueLoadImage from 'vue-load-image';
import bill from './Bill.vue';

export default {
    name: "AddSale",
    props: [
    'submit', 'product', 'categories', 'select_category', 'url', 'bill','sl', 'photo', 'name', 'quantity', 'price', 'is_order', 'discount', 'discount_2', 'vat', 'total',
    'action', 'url', 'customer_name_field', 'paid_field', 'customer_mobile_field','no_data', 'after_discount', 'after_vat', 'paid_field', 'return_field','table_no_old',
    'payable_field'
    ],
    data(){
        return {
            category_id: '',
            products: [],
            payable: "payable"
        }
    },
    methods: {
        addToSale: function(product){
            axios.post(this.url+'/admin/sale/add-to-sale', {
                product: product
            })
            .then((response) => {
                this.$store.commit('setCartiem', {
                    cartItem: response.data.cart // payload
                });

                this.$store.commit('setTotalQty', {
                    totalQty: response.data.count
                });

                this.$store.commit('setGrandTotal',{
                    grandTotal : response.data.total
                });

                this.$refs.childComponent.loadNewData();

                toastr.success("Item has been added");
            })
            .catch((exception) => {
                console.log(exception)
            });
        },
            // getCatgoryProduct: function(){
            //     axios.get(this.url+'/api/get-category-product/'+this.category_id)
            //     .then((response) => {
            //         this.products = response.data.products;
            //     })
            //     .catch((exception) => {
            //         console.log(exception);
            //     });
            // },
            makeBill: function(){
                window.location.href = this.url+"/admin/sale/bill";
            },
            categoryProduct: function(category_id){
                axios.get(this.url+'/api/get-category-product/'+category_id)
                .then((response) => {
                    this.products = response.data.products;
                })
                .catch((exception) => {
                    console.log(exception);
                });
            }
        },
        mounted() {
            axios.get(this.url+'/api/all-product')
            .then((response) => {
                this.products = response.data.products;
            })
            .catch((exception) => {
                console.log(exception);
            });

            axios.get(this.url + '/admin/sale/all-cart-item')
            .then((response) => {
                if (response.data.count > 0) {
                    this.$store.commit('setTotalQty', {
                        totalQty: response.data.count
                    });
                }
            })
            .catch((exception) => {
                console.log(exception);
            });

            this.$refs.childComponent.allCartData();
        },
        computed: {
            getTotalQty: function () {
                return this.$store.getters.getTotalQty;
            }
        },
        components: {
            'vue-load-image': VueLoadImage
        }
    }
    </script>
    <style scoped>
    .card-content{
        width: 80%;
        float: left;
    }
    .card-content p{
        margin-bottom: 5px;
    }
    .card{
        cursor: pointer;
    }
    .card-footer {
        padding: 0 1.25rem;
    }
    .slick-slide {
        outline: none;
        cursor: pointer;
    }
    .border{
        border: 3px solid gray;
    }
    .category_name {
     display: block !important;
     width: 100%;
     bottom: 0 !important;
     text-align: center;
     color: #fff;
     background: rgba(0, 150, 136, 0.8);
     white-space: nowrap;
     overflow: hidden;
     text-overflow: ellipsis;
 }
 .border-active {
    border: 2px solid rgb(0, 150, 136);
    box-sizing: content-box !important;
}
</style>
