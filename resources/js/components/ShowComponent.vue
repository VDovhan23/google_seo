<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12  mt-3">
                <div class="card card-default">
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
                        <td>{{part.position}}</td>
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
                id: this.$route.params.id,
                isActive: false
            }
        },
        methods: {
            loadParts(){
                axios.get('get_site/'+this.id).then(({data})=> {
                    this.parts = data
                    // for(var i=0; i< this.parts.length; i++){
                    //     this.parts[i].open = false;
                    // }
                })
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
                console.log(part.date)
                console.log(part.position)
            },
            manualUpdate(id) {
                var singlePart = this.parts[id-1];
                axios
                .put('/api/part/'+id, {position: singlePart.position, keyword: singlePart.keyword, date: singlePart.date, site_id: singlePart.site_id})
                .then((res)=>{
                    console.log(res);
                })
            },
            partDelete(id) {
                console.log('delete'+id);
            }
        },
        components:{ChartComponent}
    }
</script>
<style>
    .show_link{
        text-decoration: none;
    }
    /* .showGraph{
        display: block;
    } */
    .hideGraph{
        display: none;
    }
</style>
