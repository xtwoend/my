<template>
<div class="modal-body" ref="mymodal">
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Jumlah</label>
        <div class="col-sm-10">
            <input type="number" v-model="qty" class="form-control"  placeholder="jumlah">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class= "col-sm-2 col-form-label">Catatan</label>
        <div class="col-sm-10 w-full">
            <Select2 v-if="modal" class="form-control select2" :options="options" :settings="{ dropdownParent: modal }" @change="selected($event)" @select="selected($event)" />
        </div>
    </div>
    <div class="form-group row" v-if="other">
        <label for="inputEmail3" class= "col-sm-2 col-form-label"></label>
        <div class="col-sm-10 w-full">
            <input text="text" class="form-control" v-model="reason" />
        </div>
    </div>
    <div class="form-group row mg-b-0 d-flex justify-content-end">
        <div class="col-sm-10 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" @click="add">Add</button>
        </div>
    </div>
    <div class="table mt-4">
        <vuetable 
            ref="vuetable"
            class="vue-table"
            data-path="data"
            pagination-path="meta"
            :css="css.table"
            @vuetable:pagination-data="onPaginationData"
            :api-url="url"
            :fields="fields"
            :append-params="params"
        >
            <div slot="action" slot-scope="props">
                <a class="link" @click="remove(props.rowData)">Delete</a>
            </div>
        </vuetable>
        <vuetable-pagination
            ref="pagination"
            :css="css.pagination"
            @vuetable-pagination:change-page="onChangePage"
        ></vuetable-pagination>
    </div>
</div>
</template>

<script>
import Select2 from 'v-select2-component'
import Vuetable from 'vuetable-2'
import CssForBootstrap4 from './table/VuetableCssBootstrap4.js'
import VuetablePagination from './table/VuetablePagination'

export default {
    props: {
        report: Object,
        url: String
    },
    components: {
        Select2,
        Vuetable,
        VuetablePagination
    },
    mounted () {
        this.getReason()
        this.modal = this.$refs.mymodal
    },
    data () {
        return {
            qty: 0,
            reason: null,
            modal: null,
            options: [],
            other: false,

            css: CssForBootstrap4,
            keyword: "",
            fields: [
                {name: 'id', title: '#ID'},
                {name: 'qty', title: 'Jumlah'},
                {name: 'reason', title: 'Catatan'},
                {name: 'action', title: '', dataClass: 'w-80'},
            ],
            params: {},
        }
    },
    methods: {
        selected(e) {
            this.other = false
            if(e.id == 9999) {
                this.other = true
            }else{
                this.reason = e.text
            }
        },
        async getReason() {
            let options = await axios.get('/reason/dropdown').then(res => res.data)
            options.forEach(row => {
                this.options.push({id: row.id, text: row.reason})
            })
            this.options.push({id: 9999, text: 'Other'});
        },
        async add() {
           let res = await axios.post('/product/return', {report_id: this.report.id, reason: this.reason, qty: this.qty}).then(res => res.data)
           this.$refs.vuetable.reload()
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page)
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
        },
        filter() {
            this.params.q = this.keyword
            this.$refs.vuetable.reload()
        },
        remove(row) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if(r.isConfirmed) {
                    axios.delete(`/product/return/${row.id}`).then(res => {
                        this.$refs.vuetable.reload()
                    })
                }
            })
        }
    }
}
</script>

<style lang="scss">
.select2 {
    width: 100% !important;
}
.form-control {
    &.select2 {
        padding: 5px 0 !important;
    }
}
</style>