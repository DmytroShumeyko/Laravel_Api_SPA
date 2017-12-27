<template>
    <div class="company">
        <div v-if="company" class="panel panel-default">
            <div class="panel-heading company__header">
                <h1>{{company.name}}</h1>
                <div class="company__icons">
                    <button type="button" class="btn btn-primary" @click="companyModal()">Edit
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="company__primary">Total profit: {{getProfit(company).toFixed(2)}}</div>
                    <div class="company__primary"> Total debts: {{(sumProperty(company.sales, 'price') -
                        sumProperty(company.payments,
                        'value')).toFixed(2)}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="company__info">Tax: {{company.tax}}</div>
                        <div class="company__info">Phone: {{company.phone}}</div>
                        <div class="company__info">Email: {{company.email}}</div>
                        <div class="company__info">WebSite: {{company.site}}</div>
                        <div class="company__info">Address: {{company.address}}</div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="company__info">Town: {{company.town}}</div>
                        <div class="company__info">MFO: {{company.mfo}}</div>
                        <div class="company__info">itn: {{company.itn}}</div>
                        <div class="company__info">Bank: {{company.bank}}</div>
                        <div class="company__info">Account: {{company.current_account}}</div>
                    </div>
                </div>
                <div class="row">
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
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('company_orders')">Orders</button>
                    <table id="company_orders" class="table table-striped table-hover">
                        <caption>Company Orders</caption>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in company.orders">
                            <td>
                                <router-link :to="{ name: 'order', params: { id: item.id }}">{{item.id}}
                                </router-link>
                            </td>
                            <td>{{item.date}}</td>
                            <td>{{item.description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('company_sales')">Sales</button>
                    <table id="company_sales" class="table table-striped table-hover">
                        <caption>Company Sales</caption>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Cost</th>
                            <th>Payed</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in company.sales">
                            <td>
                                <router-link :to="{ name: 'sale', params: { id: item.id }}">{{item.id}}
                                </router-link>
                            </td>
                            <td>{{item.date}}</td>
                            <td>{{item.price}}</td>
                            <td>{{item.cost}}</td>
                            <td>{{item.payed}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('company_payments')">Payments
                    </button>
                    <table id="company_payments" class="table table-striped table-hover">
                        <caption>Company Payments</caption>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th><a href="" @click.prevent="openModal('add','payment','')">
                                <i class="fa fa-plus" aria-hidden="true">Add</i>
                            </a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in company.payments">
                            <td>{{item.date}}</td>
                            <td>{{item.value}}</td>
                            <td>{{item.description}}</td>
                            <td>
                                <a href="" @click.prevent="openModal('edit','payment',item)">
                                    <i class="fa fa-pencil" aria-hidden="true">Edit</i>
                                </a>
                                <a href="" @click.prevent="del(item,'payment')">
                                    <i class="fa fa-times" aria-hidden="true">Delete</i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button class="btn btn-primary toggleBtn" @click.prevent="toggle('company_withdraws')">Withdraws
                    </button>
                    <table id="company_withdraws" class="table table-striped table-hover">
                        <caption>Company Withdraws</caption>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th><a href="" @click.prevent="openModal('add','withdraw','')">
                                <i class="fa fa-plus" aria-hidden="true">Add</i>
                            </a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in company.withdraws">
                            <td>{{item.date}}</td>
                            <td>{{item.value}}</td>
                            <td>{{item.description}}</td>
                            <td>
                                <a href="" @click.prevent="openModal('edit','withdraw',item)">
                                    <i class="fa fa-pencil" aria-hidden="true">Edit</i>
                                </a>
                                <a href="" @click.prevent="del(item,'withdraw')">
                                    <i class="fa fa-times" aria-hidden="true">Delete</i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <company-vendor-modal></company-vendor-modal>
        <pay-modal></pay-modal>
    </div>
</template>

<script>
    import LineChart from '../models/LineChart'
    import CompanyVendorModal from '../components/CompanyVendorModal'
    import PayModal from '../components/PWModal'
    import router from '../routes';
    import {Bus} from '../app'

    export default {
        components: {LineChart, CompanyVendorModal, PayModal},
        props: ['id'],

        data() {
            return {
                datacollection: {},
            }
        },
        created() {
            this.fillData();
        },
        computed: {
            company() {
                let companies = this.$store.state.companies;
                let index = companies.findIndex((x) => x.id === this.id);
                return companies[index];
            },
        },
        methods: {
            toggle(item) {
                $('#' + item).toggle('slow');
            },
            fillData() {
                this.datacollection = {
                    labels: this.company.chart.dates,
                    datasets: [{
                        label: 'Profit',
                        backgroundColor: "rgba(0,140,186,0.2)",
                        data: this.company.chart.profit,
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
                    }, {
                        label: 'Payment',
                        backgroundColor: "rgba(250,50,50,0.2)",
                        data: this.company.chart2.payment,
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
            sumProperty(arr, type) {
                return arr.reduce((total, obj) => {
                    if (obj[type] == null) {
                        return total;
                    }
                    return total + parseFloat(obj[type]);
                }, 0);
            },
            getProfit(item) {
                return item.sales.reduce((total, obj) => {
                    return total + (parseFloat(obj.price) - parseFloat(obj.cost)) - (parseFloat(obj.price) * parseFloat(this.company.tax));
                }, 0);
            },
            openModal(action, condition, item){
                let data = {
                    modal_action : action,
                    modal_condition : condition,
                    modal_data : item,
                    modal_company : this.company.id
                };
                $("#pwModal").modal('show');
                Bus.$emit('pwModal', data);
            },
            companyModal(){
                let data = {
                    modal_action : 'edit',
                    modal_condition : 'company',
                    modal_data : this.company,
                };
                $("#company-vendorModal").modal('show');
                Bus.$emit('company-vendorModal', data);
            },
            del(item, condition) {
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this order!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then(function () {
                        let data = {'condition':condition, 'data': item};
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
        }
    }
</script>
<style lang="scss">

    #company_orders, #company_sales, #company_payments, #company_withdraws {
        display: none;
    }

    .company {
        &__info {
            font-size: 2rem;
            margin: 5px 0;
            text-align: center;
        }
        &__primary {
            text-align: center;
            font-size: 3rem;
            color: #3097D1;
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