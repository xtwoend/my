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
                {name: 'created_at', title: 'Date', titleClass: 'text-center w-120', formatter (val) {
                    const d = moment(val);
                    return d.format('DD-MM-YYYY')
                }},
                {name: 'schedule.shift.name', title: 'Shift'},
                {name: 'product.line', title: 'Line'},
                {name: 'product.name', title: 'SKU'},
                {name: 'qty', title: 'Jumlah'},
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