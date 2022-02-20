<template>
<div class="modal fade" :id="id" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add/Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="d-block">Shift Name</label>
                    <input v-model="form.name" type="text" class="form-control" placeholder="Shift name">                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label class="d-block">From</label>
                            <vue-timepicker :minute-interval="5" v-model="form.from" :close-on-select="false" :clear-on-select="false" :preserve-search="true"></vue-timepicker>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label class="d-block">To</label>
                            <vue-timepicker :minute-interval="5" v-model="form.to" :close-on-select="false" :clear-on-select="false" :preserve-search="true"></vue-timepicker>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="d-block">Days</label>
                    <multiselect v-model="form.day" :options="days" :multiple="true" label="name" track-by="name"></multiselect>                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" @click="save">Save</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        id: String,
        url: String,
        data: Object
    },
    data () {
        return {
            days: [
                {id: 0, name: 'Minggu'},
                {id: 1, name: 'Senin'},
                {id: 2, name: 'Selasa'},
                {id: 3, name: 'Rabu'},
                {id: 4, name: 'Kamis'},
                {id: 5, name: 'Jum\'at'},
                {id: 6, name: 'Sabtu'},
            ],
            form: {
                name: null,
                from: '',
                to: '',
                day: null
            }
        }
    },
    mounted() {
        if(this.data){
            let arr = this.data.day
            let day = this.days.filter(val => {
                return arr.includes(val.id )
            })
            Object.assign(this.form, this.data)
            // this.form = this.data
            this.form.day = day
        }
    },
    watch: {
        data: function(val) {
            if(val){
                let arr = this.data.day
                let day = this.days.filter(val => {
                    return arr.includes(val.id )
                })
                // this.form = val
                Object.assign(this.form, val)
                this.form.day = day
            }
        }
    },
    methods: {
        save() {
            if(! this.form.day)
                return;
                
            let form = {
                name: this.form.name,
                from: this.form.from,
                to: this.form.to,
                day: this.form.day.map((val) => val.id)
            }

            axios.post(this.url, form).then(res => {
                if(res.data.success) {
                    $(`#${this.id}`).modal('hide')
                    this.$emit('reload')
                }
            })
        }
    }
}
</script>

<style>

</style>