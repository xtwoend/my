<template>
<a href="#" @click="remove"><slot></slot></a>
</template>

<script>
export default {
    props: {
        url: String
    },
    methods: {
        remove() {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                console.log(r)
            })
        }
    }
}
</script>

<style>

</style>