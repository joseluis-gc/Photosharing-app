@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('App Name') }}</div>

                <div class="card-body">
                    <p class="lead">
                        My Albums
                    </p>

                    <a href="{{route('album.create')}}" class="btn btn-primary">New Album</a>
                    <br><br/>

                    <Index></Index>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
