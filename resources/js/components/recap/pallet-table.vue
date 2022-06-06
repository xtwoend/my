<template>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Pallet Code</th>
            <th>Date Production</th>
            <th>Pack Qty</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(row, i) in data" :key="row.id">
            <td>{{ row.number }}</td>
            <td>{{ row.barcode }}</td>
            <td>{{ row.production_date }}</td>
            <td>{{ row.qty }}</td>
            <td>
                <a class="btn-remove" @click="edit(row, i)">Edit</a> | 
                <a class="btn-remove" @click="remove(row, i)">Delete</a>
            </td>
        </tr>
    </tbody>
</table>
</template>

<script>
export default {
    props: {
        rows: Array
    },
    data () {
        return {
            data: []
        }
    },
    created() {
        this.rows.forEach(row => {
            this.data.push(row)
        })
    },
    methods: {
        edit(row, index) {
            this.$swal({
                title: 'Change qty',
                input: 'number',
                inputValue: row.qty,
                showCancelButton: true,
                confirmButtonText: 'Save',
                preConfirm: (qty) => {
                    return axios.put(`/pallet/${row.id}`, {qty: qty}).then(res => {
                        return res.data
                    })
                }
            }).then((result) => {
                if(result.isConfirmed) {
                    let data = result.value
                    this.data[index].qty = data.qty
                }
            })
        },
        remove (row, index) {
            // let that = this
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if(r.isConfirmed) {
                    axios.delete(`/pallet/${row.id}`).then(res => {
                        if(res.data){
                            this.data.splice(index, 1);
                            this.$swal('Success')
                        }
                    })
                }
            })
        }
    }
}
</script>

<style lang="scss">
.btn-remove {
    cursor: pointer;
}
</style>