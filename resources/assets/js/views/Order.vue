<template>
    <div class="order">
        <div v-if="order" class="panel panel-default">
            <div class="panel-heading order__header">
                <h1>{{company.name}}</h1>
                <div class="order__icons">
                    <button type="button" class="btn btn-primary" @click="edit()">Edit
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-primary" @click="del()">Delete
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="order__info">Date: {{order.date}}</div>
                <div class="order__info">Description: {{order.description}}</div>
                <div class="checkbox">
                    <label><input type="checkbox" disabled v-model="order.status">Order status</label>
                </div>
                <div>
                    <table class="table table-striped table-hover">
                        <caption>Order Items</caption>
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in order.order_items">
                            <td>{{product(item)}}</td>
                            <td>{{item.qtu}}</td>
                            <td>{{item.description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <order-modal modal_action="edit" :modal_data.sync="order"></order-modal>
    </div>
</template>

<script>
    import OrderModal from '../components/OrderModal'
    import router from '../routes';

    export default {
        props: ['id'],
        components: {OrderModal},
        data() {
            return {
                order: {}
            }
        },
        created() {
            this.order = this.order_store;
        },
        computed: {
            order_store() {
                var company_id = 0;
                var order_index = 0;
                this.$store.state.companies.forEach(function (company) {
                    let index = company.orders.findIndex((x) => x.id === this.id);
                    if (index !== -1){
                        company_id = company.id;
                        order_index = index;
                    }
                }.bind(this));
                let indexCompany = this.$store.state.companies.findIndex((x) => x.id === company_id);
                return this.$store.state.companies[indexCompany].orders[order_index];
            },
            company() {
                let companies = this.$store.state.companies;
                let index = companies.findIndex((x) => x.id === this.order.company_id);
                return companies[index];
            }
        },
        methods: {
            product(item) {
                let products = this.$store.state.products;
                let index = products.findIndex((x) => x.id === item.product_id);
                return products[index].name;
            },
            del() {
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this order!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then(function () {
                        let data = {'condition':'order', 'data': this.order};
                        this.$store.dispatch('deleteItem', data)
                            .then(() => {
                                router.go(-1);
                            });
                    }.bind(this),
                    function (dismiss) {
                        if (dismiss === 'cancel') {
                            this.$swal(
                                'Cancelled',
                                'Order is safe :)',
                                'error'
                            );
                        }
                    }.bind(this)
                );
            },
            edit() {
                $("#orderModal").modal('show');
            }
        }
    }
</script>
<style lang="scss">
    .order {
        &__info {
            font-size: 2rem;
            text-align: center;
            margin: 10px 0;
        }
        &__header {
            position: relative;
        }
        &__icons {
            position: absolute;
            right: 0;
            top: 0;
            margin: 28px;
        }
    }
</style>