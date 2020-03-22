<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <button aria-label="close"  @click.prevent="close" >×</button>
          <slot name="header" v-html="data.name">
          </slot>
        </div>
        <div class="modal-body">
            <slot name="body">
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="name"  v-model="data.name" class="form-control" placeholder="Enter name" >
                </div>
                <div class="form-group">
                  <label for="units">Units:</label>
                  <input type="text" v-model="data.units" class="form-control" placeholder="Enter units">
                </div>
                <div class="form-group">
                  <label for="price">Price:</label>
                  <input type="text" v-model="data.price" class="form-control" placeholder="Enter price">
                </div>
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea class="col-md-12" v-model="data.description" placeholder="description"></textarea>
                </div>
                <div class="form-group">
                  <span >
                    <!--show image if it is not null-->
                    <img :src="data.image" v-if="data.image">
                    <!--For previewing image after Upload-->
                    <img :src="preview" v-if="preview">
                    <input type="file" id="file" @change="attachFile" ref="fileInput">
                  </span>
                </div>
            </slot>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" @click="uploadFile">
              Finish
            </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    name:'ProductModal' , 
    props: ['product'],
    data() {
        return {
          attachment: null,
          preview: null,
          fileInput:null
        }
    } , 
    methods: {
        close(event) {
            this.$emit('closeModal');
        },
        attachFile(event) {
          //get the file name
          this.attachment = event.target.files[0];
          this.preview = URL.createObjectURL(this.attachment);
          // If there is an image preview, then data image becomes null
          if (this.preview) 
          {
            this.data.image = null;
          }
          return;
        } ,
        uploadFile(event) {
          if (this.attachment !== null) 
          {
            let formData = new FormData();
            formData.append('image' , this.attachment);
            let headers = {'Content-Type': 'multipart/form-data'}
            axios
            .post('/upload-file' , formData , {
              headers 
            })
            .then(response => {
              this.product.image = response.data;
              this.preview = null;
              //must make file input value to null or empty string
              let file = document.getElementById('file');
              file.value = '';
              this.$emit('close', this.product)
            });
          }
          else
          {
            this.$emit('close' , this.product);
          }
        },
    } ,
    computed: {
      data: function() {
        if (this.product !== null) 
        {
          console.log('product is not null')
          return this.product;
        }
        else
        {
          console.log('product is null')
          return {
            name: "" ,
            units: "" ,
            price: "",
            description: "",
            image: false
          }
        }
      }
    } , 
    mounted() {
      
    }
}
</script>
<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

.modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    border-bottom: 1px solid #eeeeee;
    color: #4AAE9B;
    justify-content: space-between;
}

.modal-footer {
    border-top: 1px solid #eeeeee;
    justify-content: flex-end;
}

.modal-body {
    position: relative;
    padding: 20px 10px;
}

.btn-close {
    border: none;
    font-size: 20px;
    padding: 20px;
    cursor: pointer;
    font-weight: bold;
    color: #4AAE9B;
    background: transparent;
}

.btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
}
</style>