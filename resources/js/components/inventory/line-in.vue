<template>
    <div class="box-table">
        <div class="d-flex align-items-center justify-content-between">
            <div class="rpp">
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-80" id="basic-addon1">DATE</span>
                    </div>
                    <input type="text" class="form-control" readonly v-model="now">
                </div>
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <span class="input-group-text w-80" id="basic-addon1">SHIFT</span>
                    </div>
                    <input type="text" class="form-control" readonly v-model="shift">
                </div>
            </div>
            <div class="search-form">
                <div class="form-group w-full">
                    <label class="d-block h-40">Scan Barcode</label>
                    <div class="input-group mg-b-10">
                        <input v-model="barcode" type="text" class="form-control" disabled>
                        <div class="input-group-append">
                            <button @click="filter" class="btn btn-outline-light" type="button"><i class="fa-solid fa-barcode"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <vuetable 
            ref="vuetable"
            class="vue-table"
            :css="css.table"
            :api-mode="false"
            :fields="fields"
            :data="data"
        >
        </vuetable>
    </div>
</template>

<script>
import Vuetable from 'vuetable-2'
import CssForBootstrap4 from '../table/VuetableCssBootstrap4.js'
import VuetablePagination from '../table/VuetablePagination'
import moment from 'moment'

export default {
    props: {
        url: String
    },
    components: {
        Vuetable,
        VuetablePagination
    },
    data () {
        return {
            css: CssForBootstrap4,
            fields: [
                {name: 'scan_time', title: 'Date', titleClass: 'w-120', formatter (val) {
                    const d = moment(val);
                    return d.format('DD-MM-YYYY')
                }},
                {name: 'scan_time', title: 'Time', titleClass: 'w-80', formatter(val) {
                    const d = moment(val);
                    return d.format('HH:mm:ss')
                }},
                {name: 'gtin', title: 'Barcode', titleClass: 'w-180'},
                {name: 'product.name', title: 'SKU'},
                {name: 'line', title: 'Line' },
                {name: 'status', title: 'Status',  titleClass: 'w-120', formatter(val) {
                    return 'Good';
                }},
            ],
            data: [],
            params: {},
            limit: 15,
            barcode: '',
            now: '',
            shift: ''
        }
    },
    created() {
        setInterval(()=> {
            this.now = this.getCurrentTime();
        }, 1000)
    },
    mounted () {
        this.listen()
        this.getLastData()
        this.getShift()
    },
    methods: {
        getCurrentTime() {
            let d = new Date()
            return moment(d).format('DD-MM-YYYY HH:mm:ss')
        },
        getShift() {
            axios.get('/schedule/active').then(res => {
                if(res.data) {
                    this.shift = res.data.shift.name
                }
            })
        },
        filter() {
            this.params.q = this.keyword
            this.$refs.vuetable.reload()
        },
        getLastData() {
            axios.get('/line-in/data').then(res => {
                this.data = res.data.data
            })
        },
        listen() {
            Echo.channel('inventory')
            .listen('InventoryIn', (e) => {
                console.log(e)
                this.data.unshift(e.data)
                this.barcode = e.data.gtin
                if(this.data.length > 15) {
                    this.data.pop()
                }
            })
        }
    }
}
</script>

<style lang="scss">
.search-form {
    width: 40%;
}
.w-full {
    width: 100%;
}
</style>