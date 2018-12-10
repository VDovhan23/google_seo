@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Fill the form</h2>
        <form method="post" action="{{ action('SiteController@update', $id)}}">
            <div class="form-group">
                <label for="site_name">Progect name</label>
                <input type="text" class="form-control" name="site_name" id="site_name"  placeholder="Project name" value="{{$site->name}}">
            </div>

            {{--має бути textarea, або ж зробити штуку яка додає інпути.--}}
            <div class="form-group">
                <label for="keywords">Keywords(поки що 1)</label>
                <input type="text" class="form-control" name="keywords" id="keywords"  placeholder="Enter site name" value="{{$site->keywords}}">
            </div>

            <div class="filters">
                <span>Results page depth:</span>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="depth"  value="50" autocomplete="off" checked > 5 Pages
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
                <label for="site_address">Edit URL коли мишка буде на цьому інпуті має появлятися пояснення про формат адреси сайту: </label>
                <input type="text" class="form-control" name="site_address" id="site_address" placeholder="Enter site address" value="{{$site->address}}">
            </div>
            <div class="submit_button" style="margin-top: 10px">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection