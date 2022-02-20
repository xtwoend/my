<template>
<div class="modal fade" :id="id" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="d-block">Location Code</label>
                    <div class="input-group mg-b-10">
                        <input v-model="data.gln" type="text" class="form-control" placeholder="Location Code" autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">
                                <i class="fa-solid fa-barcode"></i>
                            </span>
                        </div>
                    </div>                      
                </div>
                <div class="form-group">
                    <label class="d-block">Name</label>
                    <input v-model="data.name" type="text" class="form-control" placeholder="Name">
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
        product: Object,
        url: String
    },
    data () {
        return {
            data: {
                gln: null,
                name: null
            }
        }
    },
    mounted(){
        this.data = {
            gln: this.product.gln,
            name: this.product.name
        }
    },
    watch: {
        product: function(val) {
            this.data = {
                gln: val.gln,
                name: val.name
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