<template>
    <div>
       <header></header>
    </div>
</template>
<script>
import Header from './Header';
export default {
    name: 'Test' ,
    components : {
        header : Header
    } , 
    data() {
        return {
        }
    } , 
    props: {
        // name : {
        //     type: String , 
        //     default: 'Mike'
        // }
    } ,

}
</script>