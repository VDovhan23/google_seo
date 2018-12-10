@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-3">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{\Session::get('success') }}</p>
            </div><br />
        @endif
        <div class="addNew">
           <a href="{{action('SiteController@create')}}" class="btn btn-success" style="border-radius: 100px">Add NEw</a>   {{--має бути справа зверху--}}
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Keywords</th>
                <th>URL:</th>
                <th>Current Position:</th>
                <th>Frequency:</th>
                <th>Last Update Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>

            @foreach($sites as $site)
                {{--@php--}}
                    {{--$date=date('Y-m-d', $passport['date']);--}}
                {{--@endphp--}}
                <tr>
                    <td>{{$site['id']}}</td>
                    <td>{{$site['name']}}</td>
                    <td>{{$site['keywords']}}</td>
                    <td>{{$site['address']}}</td>
                    <td>{{$site['position']}}</td>
                    <td>{{$site['frequency']}}</td>
                    {{--<td>{{$site['date']}}</td> // додати--}}
                    <td>02.02.2002</td> {{-- додати--}}


                    <td><a href="{{action('SiteController@edit', $site['id'])}}" class="btn btn-warning">Edit</a></td>
                    <td>
                        <form action="{{action('SiteController@destroy', $site['id'])}}" method="post">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection