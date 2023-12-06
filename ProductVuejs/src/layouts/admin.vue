<template>
    <TheHeader />
    <router-view></router-view>
    <TheFooter />
</template>
<script>
    import TheHeader from '../components/TheHeader.vue';
    import TheFooter from '../components/TheFooter.vue';
    export default {
        components: {
            TheHeader,
            TheFooter
        }
    }
</script>