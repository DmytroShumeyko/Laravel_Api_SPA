<template>
    <div class="sales flex">
        <div class="sales__item card">
            <div class="centreXY">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saleModal">Add
                    Sale
                </button>
            </div>
        </div>
        <template v-for="company in companies">
            <div v-for="item in company.sales" class="sales__item card">
                <div class="sales__header">
                    <div class="card__title">Company: {{companyName(item)}}</div>
                </div>
                <div class="sales__body">
                    <div class="card__text">{{item.date}}</div>
                    <div class="card__text">Price: {{item.price}}</div>
                    <div class="card__text">Cost: {{item.cost}}</div>
                    <div class="card__description">{{item.description}}</div>
                </div>
                <div class="sales__footer">
                    <router-link tag="button" class="btn btn-primary" :to="{ name: 'sale', params: { id: item.id }}">
                        View
                        details
                    </router-link>
                </div>
            </div>
        </template>
        <sale-modal modal_action="add" modal_data=""></sale-modal>
    </div>
</template>

<script>
    import SaleModal from '../components/SaleModal'

    export default {
        components: {SaleModal},
        computed: {
            companies() {
                return this.$store.state.companies;
            }
        },
        methods: {
            companyName(item) {
                let companies = this.$store.state.companies;
                let index = companies.findIndex((x) => x.id === item.company_id);
                return companies[index].name;
            }
        }
    }
</script>
<style lang="scss">
    .sales {
        &__item {
            height: 250px;
            width: 200px;
        }
        &__header {
            height: 30px;
            border-bottom: 1px solid black;
        }
        &__body {
            height: 150px;
        }
        &__footer {
            height: 50px;
        }
    }
</style>