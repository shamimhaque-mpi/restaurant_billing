import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        allSale: [],
        allQty: 0,
        grandTotal: 0,
        table_no: 0,
        customer_name: '',
        mobile: '',
    },
    getters: {
        getAllSale: function (state) {
            return state.allSale;
        },
        getTotalQty: function (state) {
            return state.allQty;
        },
        getGrandTotal: function (state) {
            var value = ""+state.grandTotal+"";
            var total = value.split(',').join('');
            total = Number(total);
            return parseFloat(total).toFixed(2);
        },

    },
    mutations: {
        setAllSale: function (state, payload) {
            state.allSale = payload.sales;
        },
        setCartiem: function (state, payload) {
            state.allSale = payload.cartItem;
        },
        setTotalQty: function (state, payload) {
            state.allQty = payload.totalQty;
        },
        setGrandTotal: function (state, payload) {
            state.grandTotal = payload.grandTotal
        }
    }
});
