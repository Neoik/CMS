<template>
    <div class="container">
        <div v-if="same_ports == true" class="alert alert-danger">
            "Ports can not be same!"
        </div>
        <div class="form-group">
            <div v-if="estimate_errors['src']">
                <div v-for="error in estimate_errors['src']" class="alert alert98 alert-danger alert-dismissible">
                    <a  v-on:click="clear_estimate_errors('src')" href="#add_example" class="close" aria-label="close">&times;</a>
                    {{error}}
                </div>
            </div>
            <div class="col-md-5">
                <label>Departure Port</label>
                <b-form-select v-model="src_port" :options="ports_options"/>
            </div>
            <div v-if="estimate_errors['dst']">
                <div v-for="error in estimate_errors['dst']" class="alert alert98 alert-danger alert-dismissible">
                    <a  v-on:click="clear_estimate_errors('dst')" href="#add_example" class="close" aria-label="close">&times;</a>
                    {{error}}
                </div>
            </div>
            <div class="col-md-5">
                <label>Arrival Port</label>
                <b-form-select v-model="dst_port" :options="ports_options"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-5">
                <button v-on:click="estimate_shipping" :disabled="same_ports==true" style="width: 75%;" type="button" class="btn btn-success">Check</button>
            </div>
            <p v-if="cost != null">Estimates cost: RM{{cost}}</p>
            <p v-if="duration != null">Estimates duration: {{duration}} days</p>
        </div>
        <div class="form-group">
            <div class="col-md-5">
                <label>Shipping date</label>
                <datepicker v-model="date" :disabledDates="disabledDates"></datepicker>
            </div>
            <div class="col-md-5">
                <label>Shipping weight</label>
                <input v-model="weight" class="form-control" placeholder="Enter shipping weight">
            </div>
            <div v-if="add_errors['weight']">
                <div v-for="error in add_errors['weight']" class="alert alert98 alert-danger alert-dismissible">
                    <a  v-on:click="clear_add_errors('weight')" href="#add_example" class="close" aria-label="close">&times;</a>
                    {{error}}
                </div>
            </div>
            <div class="col-md-5">
                <label>Shipping details</label>
                <textarea v-model="description" class="form-control" rows="5" id="p_description" placeholder="Shipping details">

                </textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-5">
                <button v-on:click="add_shipping" :disabled="same_ports==true" style="width: 75%;" type="button" class="btn btn-success">Add</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            var now = new Date();
            return {
                dst_port: null,
                src_port: null,
                ports_options: {},
                same_ports: false,
                date: now,
                disabledDates: {
                    to: now,
                },
                description: "",
                weight: null,
                cost: null,
                duration: null,
                estimate_errors: {},
                add_errors: {},
            }
        },
        methods: {
            estimate_shipping: function() {
                var _this = this;
                let params = {
                    src: this.src_port,
                    dst: this.dst_port,
                }
                axios.post("/estimate", params).then(function (response) {
                    _this.estimate_errors = {}
                    _this.cost = response.data['cost']
                    _this.duration = response.data['duration']
                }).catch(function (error) {
                    if (error.response.data['errors']) {
                        let errors = error.response.data['errors']
                        _this.estimate_errors = errors
                    }
                });
            },
            add_shipping: function() {
                var _this = this;
                let d = this.date
                let str_date = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + (d.getDate()+1)
                let params = {
                    src: this.src_port,
                    dst: this.dst_port,
                    weight: this.weight,
                    date: str_date,
                    description: this.description,
                }
                axios.post("/add", params).then(function (response) {
                    _this.add_errors = {}
                    console.log(response.data)
                    let id = response.data['id']
                    window.location.href = '//' + window.location.host + '/view/' + id
                }).catch(function (error) {
                    if (error.response.data['errors']) {
                        let errors = error.response.data['errors']
                        _this.estimate_errors = errors
                        _this.add_errors = errors
                    }
                });
            },
            clear_estimate_errors: function (field) {
                this.$set(this.estimate_errors, field, null)
            },
            clear_add_errors: function (field) {
                this.$set(this.add_errors, field, null)
            },
        },
        watch: {
            src_port: function(val, oldVal) {
                if (this.dst_port == val) {
                    this.same_ports = true
                } else {
                    this.same_ports = false
                }
                console.log('!!!!', this.date)
            },
            dst_port: function(val, oldVal) {
                if (this.src_port == val) {
                    this.same_ports = true
                } else {
                    this.same_ports = false
                }
                //console.log('!!!!', this.same_ports)
            }
        },
        mounted() {
            var _this = this;
            axios.get("/ports_json").then(function (response) {
                var options = []
                response.data.forEach(function (port, _) {
                    let option = {
                        'text': port.name,
                        'value': port.id
                    }
                    options.push(option);
                });
                _this.ports_options = options
                console.log('BBBB', options)
                //console.log(response)
            }).catch(function (error) {
                console.log(error)
                if (error.response.data['errors']) {
                    let errors = error.response.data['errors']
                    //_this.errors = errors
                }
            });
        }
    }
</script>