@extends('layouts.master')

@section('my_css')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection


@section('content')
<div class="container-fluid">

    <h3>Create your project</h3>
    <form method="post" action="{{url('sites')}}" enctype="multipart/form-data">
        @csrf
    <div class="card">
            <div class="card-header"> <h4>Project details</h4>
                <p class="card-subtitle text-muted">Set options for your project</p>
            </div>
            <div class="card-body">
            <div class="form-group">
                <label for="url">URL:</label>
                <input type="text" class="form-control" id="url" name="url">
            </div>
                <div class="filters">
                    <span>Results page depth:</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="depth"  value="50" autocomplete="off" checked> 5 Pages
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="depth"  value="100" autocomplete="off"> 10 Pages
                        </label>
                    </div>
                    <span>Update frequency :</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="frequency" value="1"  autocomplete="off" > 1 Day
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="frequency" value="7"  autocomplete="off" checked> Week
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="frequency"  value="10"  autocomplete="off"> 10 Days
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="frequency"  value="30" autocomplete="off"> Montly
                        </label>
                    </div>
                </div>
            <div class="form-group">
                <label for="keywords">Keywords <small class="text-muted">separate by commas</small></label>
                <input type="text" class="form-control" id="keywords" name="keywords">
            </div>
            <button type="submit" id="site_submit" name="site_submit" class="btn btn-primary btn-lg btn-block py-3">
                Add project </button>
        </div>
    </div>
</form>
{{-- додати можливість вибору локації і конурентних сайтів --}}
</div>
@endsection
