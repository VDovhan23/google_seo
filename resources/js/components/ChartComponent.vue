<template>
   <div id="chart">
        <highcharts :options="chartOptions"  ></highcharts>
   </div>
</template>

<script>
import {Chart} from 'highcharts-vue'
    export default {
        components: {
            highcharts: Chart
        },
    props:['part'],
       data: function() {
        return {
                position: [],
                date: [],
                chartStyle:{

                },
                chartOptions: {
                    chart: {
                        width: 991,
                        backgroundColor: 'rgba(55,71,79,0.05)',
                        type: 'area',
                        zoomType: 'x',
                    },
                    title: {
                        text: this.part.keyword + ' Tracking history',
                        style: {
                            color: 'rgba(38,50,56,1)',
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    },
                    xAxis: {
                        crosshair: true,
                         labels: {
                            style: {
                                color: '#000',
                                fontSize: '14px',
                            }
                        },
                        categories: []
                    },
                    yAxis: {
                        crosshair: true,
                         labels: {
                            style: {
                                color: '#000',
                                fontSize: '14px',
                            }
                        },

                    },
                    plotOptions: {

                    },
                     series: [{
                        name: 'Keyword position',
                        data: []
                    }],
                    background: 'rgba(244,67,54,1)'
                }
            }
        },
        methods: {
            //додати конкурентів
            setChartData() {
                this.position = this.part.position.split(',')
                var result_pos = this.position.map(function (x) {
                    return parseInt(x, 10);
                });
               this.chartOptions.series[0].data = result_pos;

               this.chartOptions.xAxis.categories = this.part.date.split(',');
            }
        },
        created(){
            this.setChartData();
            //  console.log(this.chartOptions.series[0].data)
        },
    }
</script>
<style scoped>

</style>

w
