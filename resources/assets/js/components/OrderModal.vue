<template>
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Total Order Price: {{recalculate()}}</h4>
                </div>
                <div class="modal-body">
                    <div v-if="this.$store.state.errors != ''" class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" @click="closeAlert">×</a>
                        <ul v-for="error in this.$store.state.errors">
                            <li>{{ error[0] }}</li>
                        </ul>
                    </div>
                    <form action="" class="form-horizontal addVendorForm">
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Order Date</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="Date"
                                       name="date" type="date"
                                       v-model="form_order.date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="description" name="description"
                                       type="text"
                                       v-model="form_order.description">
                            </div>
                            <div class="col-xs-3">
                                <div class="checkbox">
                                    <label><input type="checkbox" v-model="form_order.status">Order status</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Company</label>
                            </div>
                            <div class="col-xs-6">
                                <select class="form-control" required v-model="form_order.company_id">
                                    <option v-for="item in companies"
                                            :value="item.id">{{item.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Products</label>
                            </div>
                            <div class="col-xs-6">
                                <select class="form-control" v-model="product" @change="addProduct(product)">
                                    <option v-for="item in products"
                                            :value="item.id">{{item.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div v-for="item in form_order.order_items" class="form-group">
                            <hr>
                            <div class="col-xs-6">
                                <label class="control-label">Product Name</label>
                                <template v-if='modal_action == "add"'>
                                    <input class="form-control" readonly :name="item.id+'_order_item'"
                                           type="text"
                                           v-model="item.name">
                                </template>
                                <template v-else>
                                    <input class="form-control" readonly :name="item.id+'_order_item'"
                                           type="text"
                                           :value="getProduct(item.product_id)">
                                </template>
                                <input type="button" class="btn btn-default btn_remove" @click="remove(item.id)"
                                       value="Remove from list">
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">Quantity</label>
                                <input class="form-control" :name="item.id+'_qtu'"
                                       type="number" v-model="item.qtu">
                                <label class="control-label">Description</label>
                                <input class="form-control" placeholder="description" :name="item.id+'_description'"
                                       type="text"
                                       v-model="item.description">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <template v-if="this.$store.state.ajax === true">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Close
                                </button>
                                <input v-if='modal_action == "edit"' slot="button" class="btn btn-primary" type="submit"
                                       value="Save" @click.prevent="edit">
                                <input v-if='modal_action == "add"'
                                       :disabled="form_order.date === '' || form_order.company_id === ''" slot="button"
                                       class="btn btn-primary" type="submit"
                                       value="Save" @click.prevent="add">
                            </template>
                            <template v-else>
                                <p>Loading</p>
                            </template>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                order_price: 0,
                product: {},
                form_order: {
                    id: '',
                    company_id: '',
                    date: '',
                    description: '',
                    status: false,
                    order_items: []
                }
            }
        },
        created() {
            if (this.modal_data !== "") {
                this.form_order = JSON.parse(JSON.stringify(this.modal_data));
            }
        },
        computed: {
            products() {
                return this.$store.state.products;
            },
            companies() {
                return this.$store.state.companies;
            }
        },
        props: ['modal_action', 'modal_data'],
        methods: {
            edit() {
                this.$store.dispatch('editOrder', this.form_order)
                    .then(() => {
                        this.$emit('update:modal_data', this.form_order)
                    });
            },
            add() {
                this.$store.dispatch('createOrder', this.form_order)
                    .then(() => {
                        this.clear();
                    });
            },
            addProduct(id) {
                let products = this.$store.state.products;
                let index = products.findIndex((x) => x.id === id);
                let product = products[index];

                this.form_order.order_items.push({
                    'name': product.name,
                    'product_id': product.id,
                    'qtu': 1,
                    'description': ''
                });
            },
            getProduct(id) {
                let products = this.$store.state.products;
                let index = products.findIndex((x) => x.id === id);
                let product = products[index];
                return product.name;
            },
            remove(id) {
                let index = this.form_order.order_items.findIndex((x) => x.id === id);
                this.form_order.order_items.splice(index, 1);

            },
            recalculate() {
                var price = 0;
                this.form_order.order_items.forEach(function (item) {

                    let products = this.$store.state.products;
                    let index = products.findIndex((x) => x.id === item.product_id);
                    let product = products[index];

                    price = price + parseFloat(product.price) * parseFloat(item.qtu);
                }.bind(this));
                return (price).toFixed(2)
            },
            clear() {
                this.product = {};
                this.order_price = 0;
                this.form_order.order_items = [];
                this.form_order.id = '';
                this.form_order.company_id = '';
                this.form_order.date = '';
                this.form_order.description = '';
                this.form_order.status = false;
            },
            closeAlert() {
                $('.close').alert();
                this.$store.commit('clearErrors');
            }
        }
    }
</script>
<style lang="scss">
    .btn_remove {
        margin: 29.4px 0 0 60px;
    }
</style>