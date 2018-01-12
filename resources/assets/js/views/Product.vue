<template>
    <div class="product">
        <div v-if="product" class="panel panel-default">
            <div class="panel-heading product__header">
                <h1>{{product.name}}</h1>
                <div class="product__icons">
                    <button type="button" class="btn btn-primary" @click="edit()">Edit
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-primary" @click="del()">Delete
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <img v-if="product.image" class="product__image circle_image" :src=product.image alt="image">
                        <img v-else class="product__image circle_image" src="/images/no_image.png" alt="no image">
                    </div>
                    <div class="col-md-9">
                        <div class="product__info">Cost:{{product.cost}}</div>
                        <div class="product__info">Price:{{product.price}}</div>
                        <div class="product__info">Sold: {{totalSold}}</div>
                        <div class="product__info">Income: {{parseFloat(product.cost) -
                            parseFloat(product.price)}}
                        </div>
                        <div class="product__info">Vendor: {{vendor.name}}</div>
                    </div>
                </div>
                <div v-if="product.product_chart != undefined" class="row">
                    <div class="col-md-12">
                        <line-chart :chart-data="datacollection"
                                    :options="{responsive: true, maintainAspectRatio: true,
                                                 scales: {
                                      yAxes: [{
                                        gridLines: {
                                          display: true
                                        }
                                      }],
                                      xAxes: [ {
                                           ticks: {
                                          beginAtZero: true,
                                        },
                                        gridLines: {
                                          display: true
                                        }
                                      }]
                                    },
                                    tooltips: {
                                    mode: 'index',
                                    intersect: false,
                                    displayColors: false,
                                    position: 'nearest'
                                    },
                                    hover: {
                                    mode: 'index',
                                    intersect: false
                                    }}"
                                    :width="1000"
                                    :height="300"></line-chart>
                    </div>
                </div>
                <div v-if="product.product_chart != undefined" class="row">
                    <div class="col-md-12">
                        <line-chart :chart-data="datacollection2"
                                    :options="{responsive: true, maintainAspectRatio: true,
                                                 scales: {
                                      yAxes: [{
                                        gridLines: {
                                          display: true
                                        }
                                      }],
                                      xAxes: [ {
                                           ticks: {
                                          beginAtZero: true,
                                        },
                                        gridLines: {
                                          display: true
                                        }
                                      }]
                                    },
                                    tooltips: {
                                    mode: 'index',
                                    intersect: false,
                                    displayColors: false,
                                    position: 'nearest'
                                    },
                                    hover: {
                                    mode: 'index',
                                    intersect: false
                                    }}"
                                    :width="1000"
                                    :height="300"></line-chart>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('orders')">Orders</button>
                    <table id="orders" class="table table-striped table-hover">
                        <caption>Product Orders</caption>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in product.order_items">
                            <td>{{item.date}}</td>
                            <td>{{item.qtu}}</td>
                            <td>{{item.description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('sales')">Sales</button>
                    <table id="sales" class="table table-striped table-hover">
                        <caption>Product Sales</caption>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in product.sale_items">
                            <td>{{item.date}}</td>
                            <td>{{item.qtu}}</td>
                            <td>{{item.price}}</td>
                            <td>{{item.cost}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('history')">History</button>
                    <table id="history" class="table table-striped table-hover">
                        <caption>Product History</caption>
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in product.old_products">
                            <td>{{item.price}}</td>
                            <td>{{item.cost}}</td>
                            <td>{{item.description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <product-modal modal_action="edit" :modal_data.sync="product"></product-modal>
    </div>
</template>

<script>
    import LineChart from '../models/LineChart'
    import ProductModal from '../components/ProductModal'

    export default {
        components: {LineChart,ProductModal},
        props: ['id'],

        data() {
            return {
                datacollection: {},
                datacollection2: {},
                product: []
            }
        },
        created() {
            let products = this.$store.state.products;
            let index = products.findIndex((x) => x.id === this.id);
            this.product = products[index];
            if (this.product.product_chart != undefined){
                this.fillData();
            }
        },
        computed: {
            vendor() {
                let vendors = this.$store.state.vendors;
                let index = vendors.findIndex((x) => x.id === this.product.vendor_id);
                return vendors[index];
            },
            totalSold() {
                var total = 0;
                if (this.product.sale_items != undefined) {
                    this.product.sale_items.forEach(function (sale) {
                        total += parseInt(sale.qtu);
                    });
                }
                return total;
            }
        },
        methods: {
            toggle(item) {
                $('#' + item).toggle('slow');
            },
            fillData() {
                this.datacollection = {
                    labels: this.product.product_chart.dates,
                    datasets: [{
                        label: 'Sales',
                        backgroundColor: "rgba(0,140,186,0.2)",
                        data: this.product.product_chart.sales,
                        /* steppedLine: true,*/
                        spanGaps: true,
                        borderWidth: 1,
                        borderColor: "rgba(0,140,186,1)",
                        pointBackgroundColor: "rgba(0,140,186,1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(0,140,186,1)",
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHitRadius: 10
                    }]
                };
                this.datacollection2 = {
                    labels: this.product.product_chart2.dates,
                    datasets: [{
                        label: 'Profit',
                        backgroundColor: "rgba(250,50,50,0.2)",
                        data: this.product.product_chart2.profit,
                        /* steppedLine: true,*/
                        spanGaps: true,
                        borderWidth: 1,
                        borderColor: "rgba(250,50,50,1)",
                        pointBackgroundColor: "rgba(0,140,186,1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(0,140,186,1)",
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHitRadius: 10
                    }]
                };
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
                        let data = {'condition':'product', 'data': this.product};
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
                $("#productModal").modal('show');
            }
        }
    }
</script>
<style lang="scss">

    #orders, #history, #sales {
        display: none;
    }

    .product{
        &__image {
            height: 110px;
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
    .circle_image{
        margin: 0 auto;
        display: block;
        border-radius: 50%;
        background: #abe2d5;
    }

</style>