<template>
    <div class="modal fade" id="company-vendorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{capitalize(modal_condition)}}</h4>
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
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Name</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="Name" type="text"
                                       v-model="form_item.name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Owner</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="John" type="text"
                                       v-model="form_item.owner">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Phone</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="+38(011)111-22-33" type="tel"
                                       v-model="form_item.phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Email</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="example@gmail.com" type="email"
                                       v-model="form_item.email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Site</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="google.com" type="text"
                                       v-model="form_item.site">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Address</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="Main str. 23" type="text"
                                       v-model="form_item.address">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Bank Account</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="021548556484652" type="text"
                                       v-model="form_item.current_account">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Bank</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="First Century Bank" type="text"
                                       v-model="form_item.bank">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} City</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="New-York" type="text"
                                       v-model="form_item.town">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Tax</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="0.05" type="number"
                                       v-model="form_item.tax">
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
                                       :disabled="form_item.name === '' || form_item.tax === ''" slot="button"
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
    import {Bus} from '../app'

    export default {
        data() {
            return {
                modal_action: '',
                modal_condition: '',
                form_item: {
                    id: '',
                    user_id: '',
                    name: '',
                    owner: '',
                    phone: '',
                    email: '',
                    site: '',
                    address: '',
                    current_account: '',
                    bank: '',
                    town: '',
                    mfo: '',
                    itn: '',
                    tax: ''
                }
            }
        },
        created() {
            Bus.$on('company-vendorModal', data => {
                this.modal_action = data.modal_action;
                this.modal_condition = data.modal_condition;
                if (data.modal_action === "edit") {
                    this.form_item = data.modal_data;
                } else {
                    this.form_item.user_id = this.user.id;
                    this.form_item.id = '';
                    this.form_item.name = '';
                    this.form_item.owner = '';
                    this.form_item.phone = '';
                    this.form_item.email = '';
                    this.form_item.site = '';
                    this.form_item.address = '';
                    this.form_item.current_account = '';
                    this.form_item.bank = '';
                    this.form_item.town = '';
                    this.form_item.mfo = '';
                    this.form_item.itn = '';
                    this.form_item.tax = '';
                }
            });
        },
        computed: {
            user() {
                return this.$store.state.user;
            },
        },
        methods: {
            edit() {
                let data = {'condition': this.modal_condition, 'data': this.form_item};
                this.$store.dispatch('editItem', data)
                    .then(() => {

                    });
            },
            add() {
                let data = {'condition': this.modal_condition, 'data': this.form_item};
                this.$store.dispatch('createItem', data);
            },
            closeAlert() {
                $('.close').alert();
                this.$store.commit('clearErrors');
            },
            capitalize(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }
    }
</script>
<style lang="scss">
    .btn_remove {
        margin: 29.4px 0 0 60px;
    }
</style>
