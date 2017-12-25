<template>
    <div class="orders flex">
        <div class="orders__item card">
            <div class="centreXY">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderModal">Add
                    Order
                </button>
            </div>
        </div>
        <div v-for="item in orders" class="orders__item card">
            <div class="orders__header">
                <div class="card__title">Company: {{company(item)}}</div>
            </div>
            <div class="orders__body">
                <div class="card__text">{{item.date}}</div>
                <div class="card__description">{{item.description}}</div>
            </div>
            <div class="orders__footer">
                <router-link tag="button" class="btn btn-primary" :to="{ name: 'order', params: { id: item.id }}">View
                    details
                </router-link>
            </div>
        </div>
        <order-modal modal_action="add" modal_data=""></order-modal>
    </div>
</template>

<script>
    import OrderModal from '../components/OrderModal'

    export default {
        components: {OrderModal},
        computed: {
            orders() {
                return this.$store.state.orders;
            }
        },
        methods: {
            company(item) {
                let companies = this.$store.state.companies;
                let index = companies.findIndex((x) => x.id === item.company_id);
                return companies[index].name;
            }
        }
    }
</script>
<style lang="scss">
    .orders {
        &__item {
            height: 170px;
            width: 200px;
        }
        &__header {
            height: 30px;
            border-bottom: 1px solid black;
        }
        &__body {
            height: 70px;
        }
        &__footer {
            height: 50px;
        }
    }
</style>