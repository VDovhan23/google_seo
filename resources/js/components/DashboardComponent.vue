<template>
<div class="container">
 <div>
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Projects</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" id="add_new" @click="newModal" >Add New <i class="fas fa-plus"></i></button>
                </div>
              </div>

              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr class="site_data">
                        <th>ID</th>
                        <th>URL</th>
                        <th>Keywords</th>
                        <th>Depth</th>
                        <th>Update Freq</th>
                        <th>Current Position</th>
                        <th>Last check date</th>
                        <th>Modify</th>
                  </tr>
                   <tr v-for="site in sites" :key="site.id" class="site_data">
                        <td>{{site.id}}</td>
                        <td> <a href="" @click.prevent="showSite(site)">{{site.domain}}</a></td>
                        <td>{{site.keywords}}</td>
                        <td>{{site.depth}}</td>
                        <td>{{site.frequency}}</td>
                        <td>{{site.position}}</td>
                        <td>{{site.updated_at | dateFormat}}</td>
                       <td>
                            <a href="">
                                <i class="fa fa-edit" @click.prevent="editModal(site)" style="color:orange"></i>
                            </a><strong>/</strong>
                            <a href="" @click.prevent="deleteSite(site.id)">
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
            <h5 class="modal-title createModalLabel " v-if="!editMode">Create your project</h5>
            <h5 class="modal-title updateModalLabel" v-else>Update your project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="editMode ? updateSite() : createSite()">

            <div class="modal-body">
                <div class="card">
                        <div class="card-header"> <h4>Project details</h4>
                            <p class="card-subtitle text-muted">Set options for your project</p>
                        </div>
                        <div class="errors">{{error}}</div><!-- додати стилі -->
                        <div class="card-body">
                        <div class="form-group">
                            <label for="url">URL:<small class="text-muted">must start with http:// or https://</small></label>
                            <input type="text" class="form-control" id="url" name="url" v-model="url">
                        </div>
                            <div class="filters">
                                <span>Results page depth:</span>
                                <div class="btn-group btn-group-toggle">
                                    <label class="btn btn-secondary ">
                                        <input cla type="radio" name="depth"  value="50" v-model="depth"> 5 Pages
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
                                    <label class="btn btn-secondary ">
                                        <input type="radio" name="frequency" value="7"  v-model="frequency"> Week
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
                <button type="submit" class="btn btn-success" v-if="!editMode">Create</button>
                <button type="submit" class="btn btn-update" v-else>Update</button>
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
                    editMode: false,
                    sites: [],
                    id: '',
                    url : '',
                    keywords:  '',
                    depth: '50',
                    frequency: '7',
                    user_id: auth_id,
                    error: ''
                }
            },
            methods: {
                newModal(){
                    this.editMode = false;
                    this.url = '';
                    this.depth = '50';
                    this.frequency  = '7';
                    this.keywords  = '';
                    $('.bd-example-modal-lg').modal('show');
                },

                editModal(data){
                    this.id = data.id
                    this.editMode = true;
                    this.url = data.domain;
                    this.depth = data.depth;
                    this.frequency  = data.frequency ;
                    this.keywords  = data.keywords ;
                    $('.bd-example-modal-lg').modal('show');
                },
                loadSites(){
                    axios.get("api/site").then(({data})=> (this.sites = data.data))
                },
                createSite() {
                    axios
                    .post('api/site', {url:this.url, keywords:this.keywords, depth:this.depth, frequency:this.frequency, user_id: auth_id})
                    .then(()=> {toast({
                            type: 'success',
                            title: 'Successfully Created'
                        })
                        $('.bd-example-modal-lg').modal('hide')
                        Fire.$emit('AfterCreate')
                    })
                    .catch((error) => {
                        toast({
                            type: 'error',
                            title: error.response.data.message
                        })
                    })
                },
                updateSite(){
                    console.log('Edit')
                     axios
                    .put('api/site/'+this.id, {url:this.url, keywords:this.keywords, depth:this.depth, frequency:this.frequency, user_id: auth_id})
                    .then(()=> {toast({
                            type: 'success',
                            title: 'Successfully Updated'
                        })
                        $('.bd-example-modal-lg').modal('hide')
                        Fire.$emit('AfterCreate')
                    })
                    .catch((error) => {
                        toast({
                            type: 'error',
                            title: error.response.data.message
                        })
                    })
                },
                deleteSite(id){
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {

                        if (result.value) {
                            //delete request
                            axios.delete('api/site/'+id)
                            .then(()=>{
                                    swal(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    )
                                Fire.$emit('AfterCreate')
                            }).catch(()=>{
                                swal('Fail!', 'Something Wrong.', 'warning')
                            })
                        }
                    })
                },
                showSite(data){
                    console.log(data);
                }

            },
            created(){
                this.loadSites();
                Fire.$on('AfterCreate', ()=>{
                    this.loadSites();
                });
            }

    }
</script>
<style>
.modal-content{
    width: 900px;
    height: 520px;
}
.errors{
    color: crimson;
    text-align: center;
}
.site_data{
    text-align: center;
}
.createModalLabel{
    color: green;
    font-size: x-large;
}
.updateModalLabel{
    color: orange;
    font-size: x-large;
}
.btn-update{
    background-color: orange;
    color: white;
}
</style>
