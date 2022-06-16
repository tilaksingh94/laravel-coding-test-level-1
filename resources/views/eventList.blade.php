@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                <table class="table table-bordered" id="events">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Event Time</th>
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

<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>

    $('#events').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ route('eventsAjax') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    { data: 'EventTime', name: 'EventTime' },
                    { data: 'action', name: 'action' }
                 ]
       });
    
  
  </script>
@endsection
