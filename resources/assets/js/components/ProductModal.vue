<template>
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Product</h4>
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
                                <label class="control-label">Product Price</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required
                                       name="price" type="number"
                                       v-model="form_product.price">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Product Cost</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required
                                       name="cost" type="number"
                                       v-model="form_product.cost">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" name="name"
                                       type="text"
                                       v-model="form_product.name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Product Image</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="File"
                                       name="image" type="file"
                                       @change="addImage">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="description" name="description"
                                       type="text"
                                       v-model="form_product.description">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="control-label">Vendor</label>
                            </div>
                            <div class="col-xs-6">
                                <select class="form-control" required v-model="form_product.vendor_id">
                                    <option v-for="item in vendors"
                                            :value="item.id">{{item.name}}
                                    </option>
                                </select>
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
                                       :disabled="form_product.date === '' || form_product.vendor_id === ''" slot="button"
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
                product_price: 0,
                product: {},
                form_product: {
                    id: '',
                    vendor_id: '',
                    name: '',
                    price: '',
                    cost: '',
                    image: '',
                    description: '',
                }
            }
        },
        created() {
            if (this.modal_data !== "") {
                this.form_product = JSON.parse(JSON.stringify(this.modal_data));
            }
        },
        computed: {
            vendors() {
                return this.$store.state.vendors;
            }
        },
        props: ['modal_action', 'modal_data'],
        methods: {
            edit() {
                let data = {'condition': 'product', 'data': this.form_product};
                this.$store.dispatch('editItem', data)
                    .then(() => {
                        this.$emit('update:modal_data', this.form_product)
                    });
            },
            add() {
                let data = {'condition': 'product', 'data': this.form_product};
                this.$store.dispatch('createItem', data)
                    .then(() => {
                        this.clear();
                    });
            },
            clear() {
                this.product = {};
                this.product_price = 0;
                this.form_product.id = '';
                this.form_product.vendor_id = '';
                this.form_product.name = '';
                this.form_product.price = '';
                this.form_product.cost = '';
                this.form_product.description = '';
                this.form_product.image = '';
            },
            closeAlert() {
                $('.close').alert();
                this.$store.commit('clearErrors');
            },
            addImage(){
                this.form_product.date = 'lololosha';
            }
        }
    }
</script>
<style lang="scss">
    .btn_remove {
        margin: 29.4px 0 0 60px;
    }
</style>