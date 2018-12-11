<template>
<div class="container">
 <div>
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Projects</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" id="add_new" data-toggle="modal" data-target=".bd-example-modal-lg">Add New <i class="fas fa-plus"></i></button>
                </div>
              </div>

              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>ID</th>
                        <th>URL</th>
                        <th>Keywords</th>
                        <th>Depth</th>
                        <th>Update Freq</th>
                        <th>Modify</th>
                  </tr>
                  <tr>
                        <td>1</td>
                        <td>wwe.com</td>
                        <td>wwe</td>
                        <td>5</td>
                        <td>10</td>
                        <td>
                            <a href="">
                                <i class="fa fa-edit" style="color:orange"></i>
                            </a><strong>/</strong>
                            <a href="">
                                <i class="fa fa-trash" style="color:red"></i>
                            </a>
                        </td>
                   </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <!-- <pagination ></pagination> -->
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create your project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="createSite()">

            <div class="modal-body">
                <div class="card">
                        <div class="card-header"> <h4>Project details</h4>
                            <p class="card-subtitle text-muted">Set options for your project</p>
                        </div>
                        <div class="card-body">
                        <div class="form-group">
                            <label for="url">URL:</label>
                            <input type="text" class="form-control" id="url" name="url" v-model="url">
                        </div>
                            <div class="filters">
                                <span>Results page depth:</span>
                                <div class="btn-group btn-group-toggle">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="depth"  value="50" v-model="depth" checked> 5 Pages
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="depth"  value="100" v-model="depth"> 10 Pages
                                    </label>
                                </div>
                                <span>Update frequency :</span>
                                <div class="btn-group btn-group-toggle">
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="frequency" value="1"  v-model="frequency"> 1 Day
                                    </label>
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="frequency" value="7"  v-model="frequency" checked> Week
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="frequency" value="10"  v-model="frequency"> 10 Days
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="frequency" value="30" v-model="frequency"> Montly
                                    </label>
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="keywords">Keywords <small class="text-muted">separate by commas</small></label>
                            <input type="text" class="form-control" id="keywords" name="keywords" v-model="keywords">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
    </form>
        </div>
    </div>
    </div>
    </div>
</div>
</template>

<script>
    export default {
            data() {
                return {
                    site: [],
                    url : '',
                    keywords:  '',
                    depth: '50',
                    frequency: '7',
                    user_id: auth_id
                }
            },
            methods: {
                createSite() {
                    axios
                    .post('api/site', {url:this.url, keywords:this.keywords, depth:this.depth, frequency:this.frequency, user_id: auth_id})
                    // .then(res=>(this.site = res.data));
                }
            },

    }
</script>
<style>
.modal-content{
    width: 900px;
    height: 520px;
}
</style>
