<template>
    <div class="sales flex">
        <div class="sales__item card">
            <div class="centreXY">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add
                    Sale
                </button>
            </div>
        </div>
        <div v-for="item in sales" class="sales__item card">
            <div class="sales__header">
                <div class="card__title">Company: {{company(item)}}</div>
            </div>
            <div class="sales__body">
                <div class="card__text">{{item.date}}</div>
                <div class="card__text">Price: {{item.price}}</div>
                <div class="card__text">Cost: {{item.cost}}</div>
                <div class="card__description">{{item.description}}</div>
            </div>
            <div class="sales__footer">
                <router-link tag="button" class="btn btn-primary" :to="{ name: 'sale', params: { id: item.id }}">View
                    details
                </router-link>
            </div>
        </div>
        <!--<add-modal :title="sale" :action="add" :data=""></add-modal>-->
    </div>
</template>

<script>
    import AddModal from '../components/AddModal'

    export default {
        computed: {
            sales() {
                return this.$store.state.sales;
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