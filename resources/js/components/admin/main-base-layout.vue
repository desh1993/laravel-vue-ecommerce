<template>
    <div>
        <h2>Main Base</h2>
        <button
        class="btn btn-success"
        @click="showing = true"
        >
            Show Modal
        </button>
        <ChildBase :showing="showing" @close="close">
            <h2>Example modal</h2>
            <form>
                <label>Name:</label>
                <input type="text" name="name" id="">

                <label>Age:</label>
                <input type="text" name="name" id="">

                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </ChildBase>
    </div>
</template>
<script>
import ChildBase from './base-layout';
export default {
    components : {
        ChildBase
    } , 
    data() {
        return {
            showing: false
        }
    } ,
    methods: {
        close(e) {
            this.showing = false;
        }
    }
}
</script>