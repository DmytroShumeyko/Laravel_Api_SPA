<!-- /components/Dashboard.vue -->

<template>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Company</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group">
                            <label for="name"></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Google Inc">
                        </div>
                        <div class="form-group">
                            <label for="owner"></label>
                            <input type="text" class="form-control" name="owner" id="owner" placeholder="First name">
                        </div>
                        <div class="form-group">
                            <label for="phone"></label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="+380117779988">
                        </div>
                        <div class="form-group">
                            <label for="email"></label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="test@google.com">
                        </div>
                        <div class="form-group">
                            <label for="site"></label>
                            <input type="text" class="form-control" name="site" id="site" placeholder="google.com">
                        </div>
                        <div class="form-group">
                            <label for="address"></label>
                            <input type="text" class="form-control" name="address" id="address"
                                   placeholder="Main str. 42">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-primary" value="add">
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

            }
        },
        props: ['action', 'data'],
        methods: {

        }
    }
</script>