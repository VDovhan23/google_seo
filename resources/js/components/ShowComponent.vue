<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
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
                  </tr>
                   <tr class="site_data">
                        <td>{{site.id}}</td>
                        <td> {{site.domain}}</td>
                        <td>{{site.keywords}}</td>
                        <td>{{site.depth}}</td>
                        <td>{{site.frequency}}</td>
                        <td>{{site.position}}</td>
                        <td>{{site.updated_at | dateFormat}}</td>

                   </tr>
                </tbody></table>
              </div>
                </div>
            </div>
            <div class="card col-md-12" >
              <div class="card-header no-border">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Position Graph</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">820</span>
                    <span>Visitors Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fa fa-arrow-up"></i> 12.5%
                    </span>
                    <span class="text-muted">Since last week</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                  <canvas id="visitors-chart" height="200" width="368" class="chartjs-render-monitor" style="display: block; width: 368px; height: 200px;"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fa fa-square text-primary"></i> This Week
                  </span>

                  <span>
                    <i class="fa fa-square text-gray"></i> Last Week
                  </span>
                </div>
              </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Show mounted.')
            axios.get('get_site/'+this.id).then(({data})=> (this.site = data))
        },
        data() {
            return {
                site:[],
                id: this.$route.params.id
            }
        },
    }
</script>
