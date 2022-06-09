<template>
<div class="box-table">
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
            <a class="link" @click="edit(props.rowData)">Edit</a> |
            <a class="link" @click="remove(props.rowData)">Delete</a>
        </div>
    </vuetable>
    <vuetable-pagination
        ref="pagination"
        :css="css.pagination"
        @vuetable-pagination:change-page="onChangePage"
    ></vuetable-pagination>
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
            keyword: "",
            fields: [
                {name: 'schedule.from', title: 'Date', titleClass: 'w-120', formatter (val) {
                    const d = moment(val);
                    return d.format('DD-MM-YYYY')
                }},
                {name: 'schedule.shift.name', title: 'Shift'},
                {name: 'product.line', title: 'Line'},
                {name: 'product.gtin', title: 'SKU'},
                {name: 'product.name', title: 'Name'},
                {name: 'product.varian_pack', title: 'Packing Varian'},
                {name: 'qty', title: 'Scan Qty', dataClass: 'text-center', titleClass: 'text-center'},
                {name: 'pallet_qty', title: 'Pallet Qty'},
                {name: 'total', title: 'Accepted', dataClass: 'text-center', titleClass: 'text-center'},
                {name: 'return_qty', title: 'Rejected'},
                {name: 'id', title: '', formatter (val) {
                    return `<a href="/recapitulation/pallet?report_id=${val}">Form (Pallet)</a>`;
                }},
                
            ],
            params: {},
            shift: null,
            editUrl: '',
            
        }
    },
    methods: {
        onChangePage(page) {
            this.$refs.vuetable.changePage(page)
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
        },
        filter() {
            this.params.q = this.keyword
            this.$refs.vuetable.reload()
        }
    }
}
</script>

<style lang="scss">
.link {
    cursor: pointer;
}
</style>