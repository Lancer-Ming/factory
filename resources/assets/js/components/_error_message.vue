<template>
    <ul>
        <li v-for="message in messages"> {{message}} </li>
    </ul>
</template>

<script>
    export default {
        props: {
            messages: {
                type: Array
            }
        }
    }
</script>
