<template>
    <div class="vendors flex">
        <div class="vendors__item card">
            <div class="centreXY">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add
                    Vendor
                </button>
            </div>
        </div>
        <div v-for="item in vendors" class="vendors__item card">
            <div class="vendors__header">
                <div class="card__title">{{item.name}}</div>
            </div>
            <div class="vendors__body">
                <div class="card__text">Products: {{item.products.length}}</div>
                <div class="card__text">Owner: {{item.owner}}</div>
                <div class="card__text">Phone: {{item.phone}}</div>
                <div class="card__text">Email: {{item.email}}</div>
                <div class="card__text">Site: {{item.site}}</div>
            </div>
            <div class="vendors__footer">
                <router-link tag="button" class="btn btn-primary" :to="{ name: 'vendor', params: { id: item.id }}">View
                    details
                </router-link>
            </div>
        </div>
        <add-modal></add-modal>
    </div>
</template>

<script>
    import AddModal from '../components/AddModal'

    export default {
        computed: {
            vendors() {
                return this.$store.state.vendors;
            }
        }
    }
</script>
<style lang="scss">
    .vendors {
        &__item {
            height: 270px;
            width: 200px;
        }
        &__header {
            height: 30px;
            border-bottom: 1px solid black;
        }
        &__body {
            height: 170px;
        }
        &__footer {
            height: 50px;
        }
    }
</style>