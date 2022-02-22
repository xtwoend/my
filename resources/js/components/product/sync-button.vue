<template>
<button type="button" @click="send" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="activity" class="wd-10 mg-r-5"></i> Send to Device</button>
</template>

<script>
export default {
    props: {
        url: String
    },
    methods: {
        send () {
            this.$swal({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if(r.isConfirmed) {
                    axios.post(this.url).then(res => {
                        this.$swal('Data sync successfull')
                    })
                }
            })
        }
    }
}
</script>

<style>

</style>