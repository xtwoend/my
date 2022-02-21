<template>
<div class="box-table">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <div></div>
        <div>
            <form method="GET">
            <div class="input-group">
                <datepicker @selected="selectedDate" name="date" input-class="form-control"></datepicker>
                <div class="input-group-append">
                    <button class="btn btn-outline-light" type="button"><i data-feather="calendar"></i></button>
                    <button class="btn btn-outline-light" type="button" @click="sync"><i data-feather="refresh-cw"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>
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
        <div slot="resync" slot-scope="props">
            <button type="button" class="btn btn-sm pd-x-15 btn-primary btn-uppercase" @click="resync(props.rowData.date)">resync</button>
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
                {name: 'date', title: 'Date', titleClass: 'text-center w-120', formatter (val) {
                    const d = moment(val);
                    return d.format('DD-MM-YYYY')
                }},
                {name: 'status', title: 'Status'},
                {name: 'trying', title: 'Trying Send'},
                {name: 'response', title: 'SAP Response'},
                {name: 'updated_at', title: 'Sync At'},
                {name: 'resync', title: ''}
            ],
            params: {},
            date: null
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
        },
        resync(date) {
            axios.post('/sync', {date: date}).then(res => {
                this.$refs.vuetable.reload();
            })
        },
        sync(){
            axios.post('/sync', {date: this.date}).then(res => {
                this.$refs.vuetable.reload();
            })
        },
        selectedDate(e) {
            const d = moment(e).format('YYYY-MM-DD');
            this.date = d
        }
    }
}
</script>

<style lang="scss">
.link {
    cursor: pointer;
}
</style>