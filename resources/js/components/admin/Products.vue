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
                <tr v-for="(product , index) in products" :key="index" @dblclick="editModal(product)" >
                    <td>{{index += 1}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.units}}</td>
                    <td>${{product.price}}</td>
                    <td>{{product.description}}</td>
                </tr>
            </tbody>
        </table>
            <!--Edit Product-->
            <ProductModal @close="editProduct" @closeModal="closeModal" :product="editingItem" v-show="editingItem !== null" ></ProductModal>
            <!--End of Edit Product-->
            <!--add product-->
            <ProductModal @close="addProduct" :product="addingProduct" @closeModal="closeModal" v-show="addingProduct !== null" >
                <template v-slot:header>
                    <div class="col-md-12">
                        <h2 class="text-center">Product Modal</h2>
                    </div>
                </template>
            </ProductModal>
            <!-- end of add product-->
            <button class="btn btn-primary" @click="newProduct" v-if="isHidden === false">Add New Product</button>

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
            editingItem : null,
            addingProduct : null,
            isHidden: false
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
        addProduct(product) {
            console.log('presenting....')
            console.log( product);
            //save to database
            axios.post('/products' , {
                name: product.name , 
                description: product.description ,
                units: product.units , 
                price: product.price , 
                image: product.image

            })
            .then(response => {
                //add to products array
                this.products.push(product);
                this.addingProduct = null;
                this.isHidden = !this.isHidden;
            });
        } , 
        newProduct() {
            //display modal form
            //making addingProduct to an obj so that it is no longer null
            this.addingProduct  = {
                    name : null, 
                    units : null, 
                    price : null,
                    description : null,
                    image : null
            };
            // this.hide = !this.hide;
            this.isHidden = !this.isHidden;
        } , 
        closeModal() {
            //to close the modal
            this.isHidden = !this.isHidden;
            this.addingProduct = null;
            if (this.editingItem !== null) 
            {
                this.editingItem = null;
            }
        } , 
        //to open modal for editing a particular product
        editModal(product) {
            this.editingItem = product;
            this.isHidden = true;
        } , 
        editProduct(product) {
            let productIndex = this.products.indexOf(product);
            console.log(productIndex)
            let id = product.id;
            axios
            .post(`/products/${id}` , {
                _method: 'patch' , 
                name : product.name,
                description : product.description,
                units : product.units , 
                price : product.price , 
                image : product.image
            })
            .then(response => {
                this.products[productIndex] = product;
                this.isHidden = !this.isHidden;
                //close the modal
                this.editingItem = null;
            })
            .catch(err => {
                console.log(err)
            });
        }
    }
}
</script>