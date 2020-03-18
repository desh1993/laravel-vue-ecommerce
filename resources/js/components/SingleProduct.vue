<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <img :src="product.image" :alt="product.name">
                <h3 class="title">{{product.name}}</h3>
                <p class="text-muted">{{product.description}}</p>
                <h4>
                    <span class="small-text text-muted float-left">$ {{product.price}}</span>
                    <span class="small-text float-right">Available Quantity: {{product.units}}</span>
                </h4>
                <br>
                <hr>
                <router-link :to="{name: 'checkout', query:{pid:this.$route.params.id}}">Checkout</router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SingleProduct' , 
    data() {
        return {
            product : []
        }
    } ,
    created() {
        axios
        .get('/products/' + this.$route.params.id)
        .then(response => {
            this.product = response.data;
        })
    }
}
</script>
<style scoped>
    .small-text { 
        font-size: 18px; 
    }
    .title { 
        font-size: 36px; 
    }
</style>