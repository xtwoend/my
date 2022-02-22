<template>
    <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" @click="print"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print</button>
</template>

<script>
import printJS from 'print-js';
export default {
    props: {
        url: String,
    },
    methods: {
        print() {
            axios.get(this.url).then(res => {
                printJS({
                    printable: res.data,
                    properties: [
                        { field: 'date', displayName: 'DATE', columnSize: 100},
                        { field: 'shift', displayName: 'SHIFT', columnSize: 50},
                        { field: 'line', displayName: 'LINE', columnSize: 50},
                        { field: 'gtin', displayName: 'BARCODE', columnSize: 100},
                        { field: 'name', displayName: 'SKU', columnSize: 200},
                        { field: 'qty', displayName: 'QTY', columnSize: 100},
                    ],
                    gridHeaderStyle: 'font-family: arial; font-size: 11px; border: 1px solid #ddd;',
                    gridStyle: 'font-family: arial; font-size: 11px; border: 1px solid #ddd;',
                    type: 'json'
                })
            })
        }
    }
}
</script>

<style lang="scss">
</style>