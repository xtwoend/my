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
                    <label class="d-block">SKU</label>
                    <div class="input-group mg-b-10">
                        <input v-model="data.gtin" type="text" class="form-control" placeholder="SKU Barcode" autofocus>
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
                <div class="form-group">
                    <label class="d-block">Line Conveyor</label>
                    <input v-model="data.line" type="text" class="form-control" placeholder="Line conveyor">
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
                gtin: null,
                name: null
            }
        }
    },
    mounted(){
        this.data = {
            gtin: this.product.gtin,
            name: this.product.name
        }
    },
    watch: {
        product: function(val) {
            this.data = {
                gtin: val.gtin,
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