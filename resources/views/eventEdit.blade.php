@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Create Event</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('eventUpdate', ['id'=>$event->id]) }}" id="eventForm">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input autocomplete="off" value="{{$event->name}}" type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter event name">
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="startAt">Start At</label>
                                <input type="text" value="{{$event->startAt}}" class="form-control" id="from" name="startAt">
                            </div>
                            <div class="col">
                                <label for="endAt">End At</label>
                                <input type="text" value="{{$event->endAt}}" class="form-control" id="to" name="endAt">
                            </div>
                        </div>
                        <button type="button" id="btn-update" class="btn btn-primary">Submit</button>
                        <span class="msg_container"></span>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    var dateFormat = "yy-mm-dd",
        from = $("#from")
        .datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: dateFormat
        })
        .on("change", function() {
            to.datepicker("option", "minDate", getDate(this));
        }),
        to = $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: dateFormat

        })
        .on("change", function() {
            from.datepicker("option", "maxDate", getDate(this));
        });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }



    $("#btn-update").click(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = $('#eventForm').serialize();
        var ajaxurl = $('#eventForm').attr('action');
        var type = $('#eventForm').attr('method');
        $('.msg_container').html('');
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('#btn-update').prop('disabled', true);
                $('#btn-update').html('saving....');
            },
            success: function(data) {
                if (data.success == 1) {
                    $('.msg_container').html('<p class="text-success">' + data.msg + '</p>');
                    toastr.success(data.msg);
                    window.location.href = "{{route('events')}}";
                }
                $('#btn-update').html('saved');
                $('#btn-update').prop('disabled', false);
            },
            error: function(request, status, error) {
                if (status == 'error') {
                    var listErrors = '<hr><ul class="text-danger">';
                    $.each(request.responseJSON.errors, function(key, value) {
                        console.log(value[0]);
                        console.log(key);
                        listErrors += '<li>' + key + ': ' + value[0] + '</li>';
                    });
                    listErrors += '</ul>';
                    $('.msg_container').html(listErrors);
                }

                $('#btn-update').html('Update Profile');
                $('#btn-update').prop('disabled', false);
            }
        });
    });
</script>

@endsection