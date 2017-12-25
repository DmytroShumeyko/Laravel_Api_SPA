<template>
    <div class="vendor">
        <div v-if="vendor" class="panel panel-default">
            <div class="panel-heading">
                <h1>{{vendor.name}}</h1>
            </div>
            <div class="panel-body">
                <div class="col-md-6 col-xs-12">
                    <div class="vendor__info">Owner: {{vendor.owner}}</div>
                    <div class="vendor__info">Phone: {{vendor.phone}}</div>
                    <div class="vendor__info">Email: {{vendor.email}}</div>
                    <div class="vendor__info">WebSite: {{vendor.site}}</div>
                    <div class="vendor__info">Address: {{vendor.address}}</div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="vendor__info">Town: {{vendor.town}}</div>
                    <div class="vendor__info">MFO: {{vendor.mfo}}</div>
                    <div class="vendor__info">itn: {{vendor.itn}}</div>
                    <div class="vendor__info">Bank: {{vendor.bank}}</div>
                    <div class="vendor__info">Account: {{vendor.current_account}}</div>
                </div>
                <div>
                    <table class="table table-striped table-hover">
                        <caption>PRODUCTS</caption>
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Cost</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="item in vendor.products">
                            <tr>
                                <td>
                                    <img v-if="item.image" class="vendor__image circle_image" :src=item.image
                                         alt="image">
                                    <img v-else class="vendor__image circle_image" src="/images/no_image.png"
                                         alt="no image">
                                </td>
                                <td>{{item.name}}</td>
                                <td>{{item.price}}</td>
                                <td>{{item.cost}}</td>
                                <td>{{item.description}}</td>
                            </tr>
                            <template v-for="old_items in item.old_products">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{old_items.price}}</td>
                                    <td>{{old_items.cost}}</td>
                                    <td>{{old_items.description}}</td>
                                </tr>
                            </template>
                        </template>
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
            vendor() {
                let vendors = this.$store.state.vendors;
                let index = vendors.findIndex((x) => x.id === this.id);
                return vendors[index];
            }
        },
        methods: {}
    }
</script>
<style lang="scss">
    .vendor {
        &__info {
            font-size: 2rem;
            text-align: center;
            margin: 10px 0;
        }
        &__image {
            height: 50px;
        }
    }
</style>