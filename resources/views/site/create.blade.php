@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Fill the form</h2>
        <form method="post" action="{{url('sites')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="site_name">Site name</label>
                <input type="text" class="form-control" name="site_name" id="site_name"  placeholder="Enter site name">
            </div>
            <div class="form-group">
                <label for="keywords">Keywords(поки що 1)</label>
                <input type="text" class="form-control" name="keywords" id="keywords"  placeholder="Enter site name">
            </div>
            <div class="form-group">
                <label for="site_address">Site address</label>
                <input type="text" class="form-control" name="site_address" id="site_address" placeholder="Enter site address">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection;