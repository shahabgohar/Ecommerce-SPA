<template>
    <section class="section">

        <h1 class="title">Description</h1>
        <h2 class="content" v-html="desc">
        </h2>

    </section>
</template>
<script>
    export default {
        props:['desc'],
    }
</script>



