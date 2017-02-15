@php
    $total=[
        "request_count" => 0,
        "request_unique_count" => 0,
        "error_request_count" => 0,
        "response_count" => 0,
        "empty_response_count" => 0,
        "error_response_count" => 0
    ];
@endphp


@extends('layouts.main')

@section('content')
<h3>Requests Statistics</h3>
<div class="input-group date" data-provide="datepicker">
    <input type="text" class="form-control">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
<table class="table statistics table-hover">
    <thead>
        <tr>
            <th>Day</th>
            <th>Client</th>
            <th>Requests</th>
            <th>Unique Requests</th>
            <th>Error Requests</th>
            <th>Responses</th>
            <th>Empty Responses</th>
            <th>Error Responses</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stat as $row)
            <tr>
                <td>{{ \App\Statistics::from_days($row->day) }}</td>
                <td><a href="/clients/{{ $row->client_id }}">{{ \App\DataClient::find($row->client_id)->name }}</a></td>
                <td>{{ $row->request_count }}</td>
                <td>{{ $row->request_unique_count }}</td>
                <td>{{ $row->error_request_count }}</td>
                <td>{{ $row->response_count }}</td>
                <td>{{ $row->empty_response_count }}</td>
                <td>{{ $row->error_response_count }}</td>
            </tr>

            @php
                $total["request_count"] += $row->request_count;
                $total["request_unique_count"] += $row->request_unique_count;
                $total["error_request_count"] += $row->error_request_count;
                $total["response_count"] += $row->response_count;
                $total["empty_response_count"] += $row->empty_response_count;
                $total["error_response_count"] += $row->error_response_count;
            @endphp


        @endforeach

        <tr>
            <td></td>
            <td><b>Total:</b></td>
            <td><b>{{ $total["request_count"] }}</b></td>
            <td><b>{{ $total["request_unique_count"] }}</b></td>
            <td><b>{{ $total["error_request_count"] }}</b></td>
            <td><b>{{ $total["response_count"] }}</b></td>
            <td><b>{{ $total["empty_response_count"] }}</b></td>
            <td><b>{{ $total["error_response_count"] }}</b></td>
        </tr>
    </tbody>
</table>


@endsection