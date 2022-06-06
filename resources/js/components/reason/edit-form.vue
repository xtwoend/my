<template>
<div class="modal fade" :id="id" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="d-block">Reason</label>
                    <input v-model="data.reason" type="text" class="form-control" placeholder="Reason">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" @click="save">Save</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        id: String,
        reason: Object,
        url: String
    },
    data () {
        return {
            data: {
                reason: null
            }
        }
    },
    mounted(){
        this.data = {
            reason: this.reason.reason,
        }
    },
    watch: {
        reason: function(val) {
            this.data = {
                reason: val.reason,
            }
        }
    },
    methods: {
        save() {
            axios.put(this.url, this.data).then(res => {
                if(res.data.success) {
                    $(`#${this.id}`).modal('hide')
                    this.$emit('reload')
                }
            })
        }
    }
}
</script>

<style>

</style>