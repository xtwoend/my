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
    <edit-form :product="product" :url="editUrl" id="product-edit" v-if="product" @reload="$refs.vuetable.reload()"></edit-form>
</div>
</template>

<script>
import Vuetable from 'vuetable-2'
import CssForBootstrap4 from '../table/VuetableCssBootstrap4.js'
import VuetablePagination from '../table/VuetablePagination'
import EditForm from './edit-form'

export default {
    props: {
        url: String
    },
    components: {
        EditForm,
        Vuetable,
        VuetablePagination
    },
    data () {
        return {
            css: CssForBootstrap4,
            keyword: "",
            fields: [
                {name: 'id', title: '#', sortField: 'id', titleClass: 'text-center w-60'},
                {name: 'gtin', title: 'SKU Barcode', sortField: 'gtin'},
                {name: 'name', title: 'Product Name', sortField: 'name'},
                {name: 'line', title: 'Line Conveyor', sortField: 'line'},
                {name: 'action', title: ''},
            ],
            params: {},
            product: null,
            editUrl: ''
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
        edit(row) {
            this.product = row
            this.editUrl = `/product/${row.id}`
            this.$nextTick(() => {
               $('#product-edit').modal('show')
            });
        },
        remove(row) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if(r.isConfirmed) {
                    axios.delete(`/product/${row.id}`).then(res => {
                        this.$refs.vuetable.reload()
                    })
                }
            })
        }
    }
}
</script>

<style lang="scss">
.link {
    cursor: pointer;
}
</style>