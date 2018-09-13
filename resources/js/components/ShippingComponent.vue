<template>
    <div class="container">
            <dl class="dl-horizontal">
                <dt>Departure Port</dt>
                <dd>{{ shipping.dst }}</dd>
                <dt>Arrival Port</dt>
                <dd>{{ shipping.src }}</dd>
                <dt>Request Date</dt>
                <dd>{{ shipping.data }}</dd>
                <dt>Status</dt>
                <div v-if="is_manager">
                    <b-form-select v-model="status" :options="status_options" class="col-md-3" />
                    <button v-on:click="update_status" class="btn btn-success">Update!</button>
                </div>
                <div v-else>
                    <dd v-bind:class="status2style[shipping.status]">
                        {{ status2msg[shipping.status] }}
                    </dd>
                </div>
            </dl>
    </div>
</template>

<script>
    export default {
        props: ['is_manager_prop'],
        data() {
            let status_options = [
                {value: 0, text: 'Pending'},
                {value: 1, text: 'Approved'},
                {value: 2, text: 'Shipping'},
                {value: 3, text: 'Delivered'},
                {value: 4, text: 'Rejected'},
            ]
            let status2msg = [
                'Pending',
                'Approved',
                'Shipping',
                'Delivered',
                'Rejected'
            ]
            let status2style = [
                'text-primary',
                'text-success',
                'text-secondary',
                'text-dark',
                'text-danger'
            ]
            return {
                'shipping': {},
                'status2msg': status2msg,
                'status2style': status2style,
                'is_manager': this.is_manager_prop,
                'status': null,
                'status_options': status_options,
            }
        },
        methods: {
            update_status: function() {
                var _this = this;
                let params = {
                    status: _this.status,
                }
                axios.post(window.location.href + "/update", params).then(function (response) {
                    console.log(response)
                }).catch(function (error) {
                    console.log(error)
                    if (error.response.data['errors']) {
                        let errors = error.response.data['errors']
                        //_this.errors = errors
                    }
                });
            },
        },
        mounted() {
            var _this = this;

            axios.get(window.location.href + "/json").then(function (response) {
                _this.shipping = response.data;
                _this.status = response.data.status
            }).catch(function (error) {
                console.log(error);
            });
            console.log('Component mounted.', this)
        }
    }
</script>