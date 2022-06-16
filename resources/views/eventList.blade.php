@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('createEvent')}}" class="btn btn-primary mb-2">Create new event</a>
            <div class="card">
                <div class="card-header">Events List </div>
                <div class="card-body">
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <table class="table table-bordered" id="events">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Event Time</th>
                                <th>updated at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')

<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    // $('#events').DataTable({
    //     processing: false,
    //     serverSide: true,
    //     ajax: "{{ route('eventsAjax') }}",
    //     columns: [{
    //             data: 'name',
    //             name: 'name'
    //         },
    //         {
    //             data: 'slug',
    //             name: 'slug'
    //         },
    //         {
    //             data: 'EventTime',
    //             name: 'EventTime'
    //         },

    //         {
    //             data: 'updated_at',
    //             name: 'updated_at'
    //         },
    //         {
    //             data: 'action',
    //             name: 'action'
    //         },
    //     ]
    // });

    var dt = $('#events').DataTable();
    $.get("{{ url('/api/v1/events') }}", function(data, status) {


        $.each(data, function(key, value) {
            var btn = '<a href="{{url("/")}}/events/' + value.id + '" class="btn btn-success btn-sm">View</a> &nbsp;';
            btn += '<a href="{{url("/")}}/events/' + value.id + '/edit"  class="btn btn-primary btn-sm">Update</a> &nbsp;';
            btn += '<a href="{{url("/")}}/events/delete/' + value.id + '"  class="btn btn-danger btn-sm">Delete</a>';

            dt.row.add([
                value.name,
                value.slug,
                value.startAt + ' To ' + value.endAt,
                value.updated_at,
                btn

            ]).draw();

        });
    });
</script>
@endsection