<template>
    <div class="companies flex">
        <div class="companies__item card">
            <div class="centreXY">
                <button type="button" class="btn btn-primary" @click.prevent="companyModal()">Add
                    Company
                </button>
            </div>
        </div>
        <div v-for="item in companies" class="companies__item card">
            <div class="companies__header">
                <div class="card__title">{{item.name}}</div>
            </div>
            <div class="companies__body">
                <div class="card__text">Total debts: {{(sumProperty(item.sales, 'price') - sumProperty(item.payments,
                    'value')).toFixed(2)}}
                </div>
                <div class="card__text">Total profit: {{getProfit(item).toFixed(2)}}</div>
            </div>
            <div class="companies__footer">
                <router-link tag="button" class="btn btn-primary" :to="{ name: 'company', params: { id: item.id }}">View
                    details
                </router-link>
            </div>
        </div>
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
        <company-modal></company-modal>
    </div>
</template>

<script>
    import LineChart from '../models/LineChart'
    import CompanyModal from '../components/CompanyModal'
    import {Bus} from '../app'

    export default {
        components: {LineChart, CompanyModal},
        data() {
            return {
                datacollection: {},
            }
        },
        created() {
            this.subscribe = this.$store.subscribe(mutation => {
                if (mutation.type === 'setData') {
                    if(this.$store.state.user.length != 0){
                        this.fillData();
                    }
                }
            });
        },
        watch: {
            '$route': 'fillData'
        },
        destroyed() {
            this.subscribe();
        },
        computed: {
            companies() {
                return this.$store.state.companies;
            },
        },
        methods: {
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
                    return total + (parseFloat(obj.price) - parseFloat(obj.cost)) - (parseFloat(obj.price) * parseFloat(item.tax));
                }, 0);
            },
            fillData() {
                this.datacollection = {
                    labels: this.$store.state.user.chart.dates,
                    datasets: [{
                        label: 'Profit',
                        backgroundColor: "rgba(0,140,186,0.2)",
                        data: this.$store.state.user.chart.profit,
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
            },
            companyModal(){
                let data = {
                    modal_action : 'add',
                    modal_data : '',
                };
                $("#companyModal").modal('show');
                Bus.$emit('companyModal', data);
            }
        }
    }
</script>
<style lang="scss">
    .companies {
        &__item {
            height: 200px;
            width: 200px;
        }
        &__header {
            height: 30px;
            border-bottom: 1px solid black;
        }
        &__body {
            height: 100px;
        }
        &__footer {
            height: 50px;
        }
    }
</style>