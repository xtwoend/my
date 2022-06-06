<template>
<div class="row row-xs">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between">
            <div class="product-info row half">
                <div class="col-12 search-form ">
                    <div class="form-group w-full mb-0">
                        <label class="d-block h-40">Input / Scan Barcode (SKU)</label>
                        <div class="input-group mg-b-10">
                            <input @blur="findProduct" v-model="gtin" type="text" ref="gtin" class="form-control" name="gtin">
                            <div class="input-group-append">
                                <button @click="findProduct"  class="btn btn-outline-light" type="button"><i class="fa-solid fa-barcode"></i></button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" v-model="product_id"/>
                </div>
                <div class="col-12">
                    <div class="form-group w-full mb-2">
                        <!-- <label class="d-block h-40">Product Name</label> -->
                        <input v-model="name" type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group mg-b-10">
                        <div class="input-group-prepend">
                            <span class="input-group-text w-120">BOX / PALLET</span>
                        </div>
                        <input type="text" class="form-control" v-model="box_pallet" name="box_pallet">
                    </div>
                </div>
            </div>
            <div class="rpp half">
                <div class="input-group mg-b-10 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-120">DATE</span>
                    </div>
                    <input type="text" class="form-control" readonly v-model="now" name="date">
                </div>
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-120">SHIFT</span>
                    </div>
                    <Select2 v-model="schedule_id" class="form-control rm" :options="options" name="schedule_id" />
                </div>
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-120">PALLET QTY</span>
                    </div>
                    <input type="text" class="form-control" v-model="pallet_qty" name="pallet_qty">
                </div>
                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file wd-10 mg-r-5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>Buat Rekap
                </button>
            </div>
        </div>
    </div>
</div><!-- row -->
</template>

<script>
import Select2 from 'v-select2-component'
import moment from 'moment'
export default {
    components: { Select2 },
    data () {
        return {
            now: null,
            product_id: null,
            gtin: null,
            name: null,
            box_pallet: null,
            schedule_id: null,
            pallet_qty: 0,
            options: []
        }
    },
    created() {
        this.getOptions();
        setInterval(()=> {
            this.now = this.getCurrentTime();
        }, 1000)
    },
    mounted() {
        this.$refs.gtin.focus();
    },
    methods: {
        createRecap() {
            if(! this.pallet_qty > 0)
                alert('Masukan jumlah pallet qty');

            if(this.gtin == null)
                alert('Pilih product dahulu');
            
        },
        findProduct() {
            let that = this
            axios.post('ajax/product', {gtin: this.gtin}).then(res => {
                let data = res.data
                if(data) {
                    that.name = `${data.name} (${data.varian_pack})`
                    that.gtin = data.gtin
                    that.box_pallet = data.box_pallet    
                    that.product_id = data.id
                }
            })
        },
        getCurrentTime() {
            let d = new Date()
            return moment(d).format('DD-MM-YYYY HH:mm:ss')
        },
        getOptions() {
            this.options = [];
            let that = this
            axios.get('/schedule/dropdown').then(res => {
                let data = res.data.data
                if(data){
                    data.forEach(function(row) {
                        let d = moment(row.from).format('DD-MM-YYYY');
                        that.options.push({id: row.id, text: `${row.shift.name} (${d})`}) 
                    })
                }
            })
        }
    }
}
</script>

<style lang="scss">
.half {
    width: 40%;
}
.rm {
    padding: 5px  0 !important;
    .select2-container {
        width: 100% !important;
    }
}
.select2-container--default 
.select2-selection--single {
    border: none !important;
    border-radius: 4px;
}
</style>