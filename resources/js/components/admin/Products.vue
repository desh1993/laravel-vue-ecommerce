<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <td></td>
                    <td>Product</td>
                    <td>Units</td>
                    <td>Price</td>
                    <td>Description</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product , index) in products" :key="index" @dblclick="editingItem">
                    <td>{{index += 1}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.units}}</td>
                    <td>${{product.price}}</td>
                    <td>{{product.description}}</td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn" @click="showModal">
            Open Modal!
        </button>
    </div>
</template>
<script>
import ProductModal from './ProductModal';
export default {
    name: 'Products',
    components: {
        ProductModal
    },
    data() {
        return {
            products: [] ,
            isModalVisible: false
        }
    } ,
    mounted() {
        axios
        .get('/products')
        .then(response => {
            this.products = response.data;
        })
    } ,
    methods: {
        editingItem(e) {
            console.log(e)
        } , 
        showModal() {
            this.isModalVisible = true;
        }
    }
}
</script>