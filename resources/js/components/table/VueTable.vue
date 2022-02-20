<template>
<div class="box-table">
    <div class="d-flex align-items-center justify-content-between">
        <div class="rpp"></div>
        <div class="search-form">
            <div class="input-group mg-b-10">
                <input v-model="keyword" @keyup.enter="filter" type="text" class="form-control" placeholder="search" aria-label="keyword">
                <div class="input-group-append">
                    <button @click="filter" class="btn btn-outline-light" type="button"><i data-feather="search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <vuetable ref="vuetable"
        class="vue-table"
        data-path="data"
        pagination-path="meta"
        :css="css.table"
        @vuetable:pagination-data="onPaginationData"
        :api-url="url"
        :fields="fields"
        :append-params="params"
    >
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
// import VuetableRowHeader from 'vuetable-2/src/components/VuetableRowHeader'
import CssForBootstrap4 from './VuetableCssBootstrap4.js'
import VuetablePagination from './VuetablePagination'

export default {
    props: {
        url: String,
        fields: Array
    },
    components: {
        Vuetable,
        // VuetableRowHeader,
        VuetablePagination
    },
    data () {
        return {
            css: CssForBootstrap4,
            keyword: "",
            params: {}
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
        isFieldSlot (fieldName) {
            return typeof this.$scopedSlots[fieldName] !== 'undefined'
        },
    }
}
</script>

<style lang="scss">
</style>