<template>
    <div class="modal fade" id="pwModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <label class="control-label">{{capitalize(modal_condition)}} Date</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" required placeholder="Date"
                                       name="date" type="date"
                                       v-model="form_item.date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Description</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="description" name="description"
                                       type="text"
                                       v-model="form_item.description">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="control-label">{{capitalize(modal_condition)}} Value</label>
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" placeholder="10.00" name="value"
                                       type="number"
                                       v-model="form_item.value">
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
                                       :disabled="form_item.date === '' || form_item.company_id === ''" slot="button"
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
                modal_action:'',
                modal_condition:'',
                form_item: {
                    id: '',
                    company_id: '',
                    date: '',
                    description: '',
                    value: '',

                }
            }
        },
        created() {
            Bus.$on('pwModal', data => {
                this.modal_action = data.modal_action;
                this.modal_condition = data.modal_condition;
                if (data.modal_action === "edit") {
                    this.form_item = data.modal_data;
                }else{
                    this.form_item.company_id = data.modal_company;
                    this.form_item.id = '';
                    this.form_item.date = '';
                    this.form_item.description = '';
                    this.form_item.value = '';
                }
            });
        },
        computed: {
            products() {
                return this.$store.state.products;
            },
            companies() {
                return this.$store.state.companies;
            }
        },
        methods: {
            edit() {
                let data = {'condition':this.modal_condition, 'data': this.form_item};
                this.$store.dispatch('editItem', data)
                    .then(() => {

                    });
            },
            add() {
                let data = {'condition':this.modal_condition, 'data': this.form_item};
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
