<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12  mt-3">
                <div class="card card-default">
                      <!-- <div class="card-header"> -->
                <!-- <h3 class="card-title">My Projects</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" id="add_keyword"  >Add New <i class="fas fa-plus"></i></button>
                </div>-->
              </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr class="site_data">
                        <th>ID</th>
                        <th>Keyword</th>
                        <th>URL</th>
                        <th>Current Position</th>
                        <th>Last check date</th>
                        <th>Competitor</th>
                        <th>Update info</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                  <tbody class="site_data" v-for="part in parts" :key='part.id'>
                   <tr>
                        <td>{{part.id}}</td>
                        <td><a class="show_link" href="" @click.prevent="showPartInfo(part.id)">{{part.keyword}}</a></td>
                        <td>{{part.domain}}</td>
                        <td style="max-width: 200px;">
                            <span v-if="getDifference(part.position)[2]=='null'">
                                    {{getDifference(part.position)[0]}}
                                    <span class="text-primary mr-1"> <i class="fa fa-minus"></i></span>
                            </span>
                            <span v-if="getDifference(part.position)[2]=='false'">
                                    {{getDifference(part.position)[0]}}
                                     <span class="text-danger mr-1" v-if="getDifference(part.position)[1] "> <i class="fa fa-arrow-down"></i>{{getDifference(part.position)[1]}}</span>
                            </span>
                            <span v-if="getDifference(part.position)[2]=='true'">
                                    {{getDifference(part.position)[0]}}
                                    <span class="text-success mr-1" v-if="getDifference(part.position)[1] "> <i class="fa fa-arrow-up"></i>{{getDifference(part.position)[1]}}</span>
                            </span>
                        </td>
                        <td>{{part.updated_at | dateFormat}}</td>
                        <td>{{part.competitor}}</td>
                        <td><button class="btn btn-success" @click.prevent="manualUpdate(part.id)">Update now</button></td>
                        <td><button class="btn btn-danger" @click.prevent="partDelete(part.id)">Delete</button></td>
                   </tr>
                   <tr :id="'graph'+part.id" class="hideGraph" >
                       <td colspan="8">
                           <chart-component
                           :part="part"
                           ></chart-component>
                       </td>
                   </tr>
                </tbody>
                </table>
              </div>
            </div>
            </div>

        </div>
    </div>
</template>

<script>
import ChartComponent from './ChartComponent.vue'
    export default {
       created() {
            this.loadParts();
        },

        data() {
            return {
                parts:[],
                id: this.$route.params.id
            }
        },
        methods: {
            loadParts(){
                axios.get('get_site/'+this.id).then(({data})=> {
                    this.parts = data
                })
            },
            getDifference(data){
                var split = data.split(',')
                var last = split[split.length-1];
                var previus = split[split.length-2];
                var diff = previus - last;
                var plus = 'null';
                if (diff > 0){
                    var plus = 'true';
                }
                else if (diff == 0) {
                     var plus = "null"
                }
                else{
                    var plus = 'false';
                }
                return [last ,diff, plus];
            },
            showPartInfo(id){
                var part = this.parts[id-1];
                if($('#graph'+part.id).hasClass('hideGraph')){
                    $('#graph'+part.id).removeClass('hideGraph')
                    $('#graph'+part.id).addClass('showGraph')
                }else{
                    $('#graph'+part.id).removeClass('showGraph')
                    $('#graph'+part.id).addClass('hideGraph')
                }
            },
            manualUpdate(id) {
                var singlePart = this.parts[id-1];
                axios
                .put('/api/part/'+id, {position: singlePart.position, keyword: singlePart.keyword, date: singlePart.date, site_id: singlePart.site_id})
                .then((res)=>{
                    console.log(res);
                })
                location.reload();
            },
            partDelete(id) {
                swal({
                    title: 'Are you sure?',
                    text: "If it's last keyword in project, project will be deleted. You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {
                        //delete request
                        axios.delete('/api/part/'+id)
                        .then((res)=>{
                                swal(
                                'Deleted!',
                                res.data.message,
                                'success'
                                );
                                this.loadParts();
                        }).catch(()=>{
                            swal('Fail!', 'Something Wrong.', 'warning')
                        })
                    }
                })

            }
        },
        components:{ChartComponent}
    }
</script>
<style scoped>
    .show_link{
        text-decoration: none;
    }

    .hideGraph{
        display: none;
    }

</style>
