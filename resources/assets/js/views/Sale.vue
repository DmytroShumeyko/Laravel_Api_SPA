<template>
    <div class="sale">
        <div v-if="sale" class="panel panel-default">
            <div class="panel-heading sale__header">
                <h1>{{company.name}}</h1>
                <div class="sale__icons">
                    <button type="button" class="btn btn-primary" @click="edit()">Edit
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-primary" @click="del()">Delete
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="sale__info">Date: {{sale.date}}</div>
                <div class="sale__info">Description: {{sale.description}}</div>
                <div class="sale__info">{{sale.ttn}}</div>
                <div class="col-md-6 col-xs-12">
                    <div class="sale__info">Price: {{sale.price}}</div>
                    <div class="sale__info">Cost: {{sale.cost}}</div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="sale__info">Profit: {{((parseFloat(sale.price) - parseFloat(sale.cost)) -
                        parseFloat(company.tax) * parseFloat(sale.price)).toFixed(2)}}
                    </div>
                    <div class="sale__info">Tax: {{(parseFloat(company.tax) * parseFloat(sale.price)).toFixed(2)}}</div>
                </div>
                <div>
                    <table class="table table-striped table-hover">
                        <caption>sale Items</caption>
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in sale.sale_items">
                            <td>{{product(item)}}</td>
                            <td>{{item.qtu}}</td>
                            <td>{{item.price}}</td>
                            <td>{{item.cost}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <sale-modal modal_action="edit" :modal_data.sync="sale"></sale-modal>
    </div>
</template>

<script>
    import SaleModal from '../components/SaleModal'
    import router from '../routes';

    export default {
        props: ['id'],
        components: {SaleModal},
        data() {
            return {
                sale: {}
            }
        },
        created() {
            this.sale = this.sale_store;
        },
        computed: {
            sale_store(){
                var company_id = 0;
                var sale_index = 0;
                this.$store.state.companies.forEach(function (company) {
                    let index = company.sales.findIndex((x) => x.id === this.id);
                    if (index !== -1){
                        company_id = company.id;
                        sale_index = index;
                    }
                }.bind(this));
                let indexCompany = this.$store.state.companies.findIndex((x) => x.id === company_id);
                return this.$store.state.companies[indexCompany].sales[sale_index];
            },
            company() {
                let companies = this.$store.state.companies;
                let index = companies.findIndex((x) => x.id === this.sale.company_id);
                return companies[index];
            },
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
                        let data = {'condition':'sale', 'data': this.sale};
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
                $("#saleModal").modal('show');
            }
        }
    }
</script>
<style lang="scss">
    .sale {
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