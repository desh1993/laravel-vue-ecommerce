<template>
    <div>
        <h2>hello {{query}}</h2>
    </div>
</template>
<script>
export default {
    name: 'Search' ,
    data() {
        return {
        }
    } , 
    props: ['query']
}
</script>