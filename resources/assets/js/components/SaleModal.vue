<template>
    <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sale</h4>
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
                                <label class="control-label">Sale Price</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required
                                       name="price" type="hidden"
                                       v-model="form_sale.date">
                                <input class="form-control" readonly
                                       :value="recalculate('price')">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Sale Cost</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required
                                       name="cost" type="hidden"
                                       v-model="form_sale.cost">
                                <input class="form-control" readonly
                                       :value="recalculate('cost')">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Payed</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" name="payed"
                                       type="number"
                                       v-model="form_sale.payed">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Sale Date</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="Date"
                                       name="date" type="date"
                                       v-model="form_sale.date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="description" name="description"
                                       type="text"
                                       v-model="form_sale.description">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Sale TTN</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control"
                                       name="ttn" type="text"
                                       v-model="form_sale.ttn">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Company</label>
                            </div>
                            <div class="col-xs-6">
                                <select class="form-control" required v-model="form_sale.company_id">
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
                        <div v-for="item in form_sale.sale_items" class="form-group">
                            <hr>
                            <div class="col-xs-6">
                                <label class="control-label">Product Name</label>
                                <template v-if='modal_action == "add"'>
                                    <input class="form-control" readonly :name="item.id+'_sale_item'"
                                           type="text"
                                           v-model="item.name">
                                </template>
                                <template v-else>
                                    <input class="form-control" readonly :name="item.id+'_sale_item'"
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
                                <label class="control-label">Price</label>
                                <input class="form-control" :name="item.id+'_price'" readonly
                                       type="number" v-model="item.price">
                                <label class="control-label">Cost</label>
                                <input class="form-control" :name="item.id+'_cost'" readonly
                                       type="number" v-model="item.cost">
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
                                       :disabled="form_sale.date === '' || form_sale.company_id === ''" slot="button"
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
                sale_price: 0,
                product: {},
                form_sale: {
                    id: '',
                    company_id: '',
                    price: '',
                    cost: '',
                    payed: '',
                    ttn: '',
                    date: '',
                    description: '',
                    sale_items: []
                }
            }
        },
        created() {
            if (this.modal_data !== "") {
                this.form_sale = JSON.parse(JSON.stringify(this.modal_data));
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
                let data = {'condition': 'sale', 'data': this.form_sale};
                this.$store.dispatch('editItem', data)
                    .then(() => {
                        this.$emit('update:modal_data', this.form_sale)
                    });
            },
            add() {
                let data = {'condition': 'sale', 'data': this.form_sale};
                this.$store.dispatch('createItem', data)
                    .then(() => {
                        this.clear();
                    });
            },
            addProduct(id) {
                let products = this.$store.state.products;
                let index = products.findIndex((x) => x.id === id);
                let product = products[index];

                this.form_sale.sale_items.push({
                    'name': product.name,
                    'product_id': product.id,
                    'qtu': 1,
                    'price': product.price,
                    'cost': product.cost,
                });
            },
            getProduct(id) {
                let products = this.$store.state.products;
                let index = products.findIndex((x) => x.id === id);
                let product = products[index];
                return product.name;
            },
            remove(id) {
                let index = this.form_sale.sale_items.findIndex((x) => x.id === id);
                this.form_sale.sale_items.splice(index, 1);

            },
            recalculate(element) {
                var condition = 0;
                this.form_sale.sale_items.forEach(function (item) {

                    let products = this.$store.state.products;
                    let index = products.findIndex((x) => x.id === item.product_id);
                    let product = products[index];

                    switch (element) {
                        case 'price':
                            item.price = (parseFloat(product.price) * parseFloat(item.qtu)).toFixed(2);
                            condition = condition + parseFloat(item.price);
                            break;
                        case 'cost' :
                            item.cost = (parseFloat(product.cost) * parseFloat(item.qtu)).toFixed(2);
                            condition = condition + parseFloat(item.cost);
                            break;
                    }

                }.bind(this));
                switch (element) {
                    case 'price':
                        this.form_sale.price = condition;
                        break;
                    case 'cost' :
                        this.form_sale.cost = condition;
                        break;
                }
                return (condition).toFixed(2)
            },
            clear() {
                this.product = {};
                this.sale_price = 0;
                this.form_sale.sale_items = [];
                this.form_sale.id = '';
                this.form_sale.company_id = '';
                this.form_sale.date = '';
                this.form_sale.ttn = '';
                this.form_sale.price = '';
                this.form_sale.cost = '';
                this.form_sale.payed = '';
                this.form_sale.description = '';
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