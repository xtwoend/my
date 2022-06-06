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

    <edit-form :reason="reason" :url="editUrl" id="reason-edit" v-if="reason" @reload="$refs.vuetable.reload()"></edit-form>

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
                {name: 'id', title: '#ID'},
                {name: 'reason', title: 'Reason'},
                {name: 'action', title: '', dataClass: 'w-120'},
            ],
            params: {},
            editUrl: '',
            reason: null,
            
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
            this.reason = row
            this.editUrl = `/reason/${row.id}`
            this.$nextTick(() => {
               $('#reason-edit').modal('show')
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
                    axios.delete(`/reason/${row.id}`).then(res => {
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