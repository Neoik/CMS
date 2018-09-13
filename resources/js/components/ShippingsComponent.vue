<template>
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Shipping ID</th>
                    <th scope="col">Departure Port</th>
                    <th scope="col">Arrival Port</th>
                    <th scope="col">Request Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="shipping in shippings" :key="shipping.id">
                        <td>
                            {{ shipping.id }}
                        </td>
                        <td>
                            {{ shipping.dst }}
                        </td>
                        <td>
                            {{ shipping.src }}
                        </td>
                        <td>
                            {{ shipping.data }}
                        </td>
                        <td v-bind:class="status2style[shipping.status]">
                            {{ status2msg[shipping.status] }}
                        </td>
                        <td>
                            <a v-bind:href="'/view/'+shipping.id">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button v-on:click="create_shipping()" class="btn btn-success" id="shipping_adder" title="add new order">Add</button>
    </div>
</template>

<script>
    export default {
        data() {
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
                'shippings': null,
                'status2msg': status2msg,
                'status2style': status2style,
            }
        },
        methods: {
            create_shipping: function() {
                location.href = '/add'
            },
        },
        mounted() {
            axios.get('/shippings').then(response => (this.shippings = response.data)).catch(function (error) {
                console.log(error);
            })
            //console.log('Component mounted.', this)
        }
    }
</script>

<style>
#shipping_adder {
    position: fixed;
    bottom: 20px;
    right: 30px;
    z-index: 99;
    padding: 15px;
}
</style>