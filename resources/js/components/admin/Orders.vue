<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <td>Order</td>
                    <td>Product</td>
                    <td>Quantity</td>
                    <td>Cost</td>
                    <td>Delivery Address</td>
                    <td>is Delivered?</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order,index) in orders" :key="index">
                    <td>{{index+1}}</td>
                    <td v-html="order.product.name"></td>
                    <td>{{order.quantity}}</td>
                    <td>{{order.quantity * order.product.price}}</td>
                    <td>{{order.address}}</td>
                    <td>{{order.is_delivered == 1? "Yes" : "No"}}</td>
                    <td v-if="order.is_delivered == 0"><button class="btn btn-success" @click="deliver(index)">Deliver</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: 'Orders',
    data() {
        return {
            orders:[],
            
        }
    } , 
    created() {
        axios.get('/orders')
        .then(response => {
            this.orders = response.data;
        })
    } , 
    methods : {
        deliver(index) {
            let order = this.orders[index].id;
            axios.post(`/orders/${order}/deliver` , {
                _method: 'patch'
            })
            .then(response => {
                this.orders[index].is_delivered = 1;
                //Force the Vue instance to re-render. Note it does not affect all child components, only the instance itself and child components with inserted slot content.
                this.$forceUpdate();
            })
            .catch(err => console.log(err))
        }
    }
}
</script>