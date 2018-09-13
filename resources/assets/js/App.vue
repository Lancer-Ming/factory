<template>
    <div>
        <Header/>
        <!--<div id="main-container" class="container main-container">-->
            <router-view/>
        11
        <!--</div>-->
        <Footer/>
    </div>
</template>
<script>
    import Header from './components/layouts/Header'
    import Sidebar from './components/layouts/Sidebar'
    import Footer from './components/layouts/Footer'
    export default {
        name: 'App',
        components: {
            Header,
            Sidebar,
            Footer
        },
    }
</script>