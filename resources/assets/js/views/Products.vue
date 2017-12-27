<template>
    <div class="products flex">
        <div class="products__item card">
            <div class="centreXY">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add
                    Product
                </button>
            </div>
        </div>
        <div v-for="item in products" class="products__item card">
            <div class="products__header">
                <p class="products__title">{{item.name}}</p>
                <img v-if="item.image" class="products__image circle_image" :src=item.image alt="image">
                <img v-else class="products__image circle_image" src="/images/no_image.png" alt="no image">
            </div>
            <div class="products__body">
                <div class="row">
                    <div class="col-md-6 col-xs-12">Cost: {{item.cost}}</div>
                    <div class="col-md-6 col-xs-12">Price: {{item.price}}</div>
                </div>
                <div class="products__sales">Total sales: {{item.sale_items.length}}</div>
                <div class="products__sold">Total sold: {{totalSold(item)}}</div>
            </div>
            <div class="products__footer">
                <router-link tag="button" class="btn btn-primary" :to="{ name: 'product', params: { id: item.id }}">View
                    details
                </router-link>
            </div>
        </div>
        <add-modal></add-modal>
    </div>
</template>

<script>
    import AddModal from '../components/CompanyModal'

    export default {
        computed: {
            products() {
                return this.$store.state.products;
            }
        },
        methods: {
            totalSold(item) {
                var total = 0;
                item.sale_items.forEach(function (sale) {
                    total += parseInt(sale.qtu);
                });
                return total;
            }
        }
    }
</script>
<style lang="scss">
    .products {
        &__item {
            height: 300px;
            width: 250px;
        }
        &__header {
            height: 180px;
            border-bottom: 1px solid black;
        }
        &__title {
            font-size: 2rem;
        }
        &__body {
            height: 70px;
        }
        &__footer {
            height: 50px;
        }
        &__image {
            height: 130px;
        }
    }
</style>