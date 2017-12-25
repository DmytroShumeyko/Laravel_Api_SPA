<template>
    <div class="sale">
        <div v-if="sale" class="panel panel-default">
            <div class="panel-heading">
                <h1>{{company.name}}</h1>
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
    </div>
</template>

<script>
    export default {
        props: ['id'],
        computed: {
            sale(){
                let sales = this.$store.state.sales;
                let index = sales.findIndex((x) => x.id === this.id);
                return sales[index];
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
    }
</style>