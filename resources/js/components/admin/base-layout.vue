<template>
    <div class="container">
        <h2>child base</h2>
    <header>
        <!-- We want header content here -->
        <slot name="header">
        </slot>
    </header>
    <main>
        <!-- We want main content here -->
        <slot></slot>
    </main>
    <article>
        <div class="col-md-12">
            <slot name="article"></slot>
        </div>
    </article>
    <footer>
        <!-- We want footer content here -->
        <slot name="footer"></slot>
    </footer>
    </div>
</template>
<script>
export default {
    name: 'ChildBase' ,
    data() {
        return {

        }
    }
}
</script>