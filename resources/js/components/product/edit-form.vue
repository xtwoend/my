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
                    <label class="d-block">SKU Barcode</label>
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
                    <label class="d-block">Packing Varian</label>
                    <input v-model="data.varian_pack" type="text" class="form-control" placeholder="Packing Varian">
                </div>
                <div class="form-group">
                    <label class="d-block">Line Conveyor</label>
                    <input v-model="data.line" type="text" class="form-control" placeholder="Line conveyor">
                </div>
                <div class="form-group">
                    <label class="d-block">Box / Pallet</label>
                    <input v-model="data.box_pallet" type="text" class="form-control" placeholder="Box per pallet">
                </div>
                <div class="form-group">
                    <label class="d-block">Description</label>
                    <textarea v-model="data.description" rows="3" class="form-control" placeholder="Description"></textarea>
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
                name: null,
                line: null,
                varian_pack: null,
                box_pallet: null,
                description: null
            }
        }
    },
    mounted(){
        this.data = {
            gtin: this.product.gtin,
            name: this.product.name,
            line: this.product.line,
            varian_pack: this.product.varian_pack,
            box_pallet: this.product.box_pallet,
            description: this.product.description
        }
    },
    watch: {
        product: function(val) {
            this.data = {
                gtin: val.gtin,
                name: val.name,
                line: val.line,
                varian_pack: val.varian_pack,
                box_pallet: val.box_pallet,
                description: val.description
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