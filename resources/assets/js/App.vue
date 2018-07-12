<template>
    <div id="wrap">
        <Header/>
        <div id="main-container" class="container main-container">
            <router-view/>
        </div>
        <Footer/>
    </div>
</template>
<script>
    import Header from './components/layouts/Header'
    import Footer from './components/layouts/Footer'
    export default {
        name: 'App',
        components: {
            Header,
            Footer
        },
    }
</script>

<style lang="scss">

</style>