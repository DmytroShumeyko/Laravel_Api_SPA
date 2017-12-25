<!-- /components/Dashboard.vue -->

<template>
    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add product</h4>
                </div>
                <div class="modal-body">
                    <form action="#" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select class="form-control" name="vendor_id" id="vendor" >
                                <option v-for="item in vendors" :value="item.id">{{item.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Google Inc">
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" class="form-control" name="cost" id="cost" placeholder="10.25">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="18.50">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="google.com">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" accept=".jpg" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-primary" value="ADD PRODUCT" @click.prevent="add()">
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
        computed:{
          vendors(){
              return this.$store.state.vendors;
          }  
        },
        methods: {
            add(){

            }
        }
    }
</script>