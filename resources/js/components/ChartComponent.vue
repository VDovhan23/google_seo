<template>
    <div >
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">CHART Component</div>

                <div class="card-body">
                    {{part.keyword}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['part'],
        mounted() {
            console.log('Chart mounted.')
        },
        data() {
            return {
                chartData: []
            }
        },
    }
</script>
<style>

</style>


