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

                chartOptions: {
                    chart: {
                        styledMode: false,
                        width: 991,
                        backgroundColor: 'rgba(55,71,79,0.05)',
                        type: 'area',
                        zoomType: 'x',
                    },
                    navigation: {
                        buttonOptions: {
                            enabled: true
                        }
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
                         type: 'datetime'
                        },
                        categories: []
                    },
                    yAxis: {
                        crosshair: true,
                         labels: {
                            style: {
                                color: 'rgba(55,71,79,0.05)',
                                fontSize: '14px',
                            }
                        },

                    },
                    plotOptions: {

                    },
                     series: [{
                        name: this.part.domain, // імя сайту, потім будуть конкуренти
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

/* @import 'https://code.highcharts.com/css/highcharts.css'; if style mode true */

</style>

