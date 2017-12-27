<template>
    <div class="user">
        <div v-if="user" class="panel panel-default">
            <div class="panel-heading user__header">
                <h1>{{user.name}}</h1>
                <div class="user__icons">
                    <button type="button" class="btn btn-primary" @click.prevent="edit()">Edit
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-6 col-xs-12">
                    <div class="user__info">Phone: {{user.phone}}</div>
                    <div class="user__info">Email: {{user.email}}</div>
                    <div class="user__info">WebSite: {{user.site}}</div>
                    <div class="user__info">Address: {{user.address}}</div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="user__info">Town: {{user.town}}</div>
                    <div class="user__info">MFO: {{user.mfo}}</div>
                    <div class="user__info">itn: {{user.itn}}</div>
                    <div class="user__info">Bank: {{user.bank}}</div>
                    <div class="user__info">Account: {{user.current_account}}</div>
                </div>
            </div>
        </div>
        <company-vendor-modal></company-vendor-modal>
    </div>
</template>

<script>
    import CompanyVendorModal from '../components/CompanyVendorModal'
    import {Bus} from '../app'

    export default {
        props: ['id'],
        components: {CompanyVendorModal},
        data() {
            return {
                user: {}
            }
        },
        created() {
            this.user = this.user_store;
        },
        computed: {
            user_store() {
                return this.$store.state.user;
            },
        },
        methods: {
            edit() {
                let data = {
                    modal_action: 'edit',
                    modal_condition: 'user',
                    modal_data: this.user,
                };
                $("#company-vendorModal").modal('show');
                Bus.$emit('company-vendorModal', data);
            }
        }
    }
</script>
<style lang="scss">
    .user {
        &__info {
            font-size: 2rem;
            text-align: center;
            margin: 10px 0;
        }
        &__header {
            position: relative;
        }
        &__icons {
            position: absolute;
            right: 0;
            top: 0;
            margin: 28px;
        }
    }
</style>