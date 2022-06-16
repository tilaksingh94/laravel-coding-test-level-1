@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"> Individual event</div>
                <div class="card-body">
                    <a href="{{route('events')}}" class="btn btn-primary btn-sm">Back</a>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">Event Name</div>
                        <div class="col-md-6">{{ucfirst($event->name)}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Slug</div>
                        <div class="col-md-6"><code>{{$event->slug}}</code></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Event Start/End</div>
                        <div class="col-md-6"><code>{{$event->startAt}} To {{$event->endAt}}</code></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Created At</div>
                        <div class="col-md-6">{{$event->created_at}}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">Updated At</div>
                        <div class="col-md-6">{{Carbon\Carbon::create($event->updated_at)->diffForHumans()}}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection