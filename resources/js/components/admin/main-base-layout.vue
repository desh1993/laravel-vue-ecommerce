<template>
    <div>
        <h2>Main Base</h2>
        <ChildBase>
            <template v-slot:header>
                <h3>Here might be a page title</h3>
            </template>
            <p>A paragraph for the main content.</p>
            <p>And another one.</p>
            <template v-slot:article>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. A unde, distinctio esse facilis possimus voluptate sunt officiis libero eius, doloremque nulla! Necessitatibus ipsum praesentium optio quas minima asperiores nam unde.</p>
            </template>
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

        }
    }
}
</script>