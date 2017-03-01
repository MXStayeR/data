@php $total = \App\DataRequestStat::$incrementers; @endphp
@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3>Requests Statistics</h3>
</div>
<div class="container report-params">
    <form action="{{ route('request_statistics') }}" method="POST">
        {{ csrf_field() }}
        <div class="col-sm-2 input-group">
            <input type="text"
                   class="datepicker form-control"
                   name="day_start"
                   placeholder="From:"
                   value="@if($request->has("day_start")) {{ $request->day_start }} @endif"
            >
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
        <div class="col-sm-2 input-group">
            <input type="text"
                   class="datepicker form-control"
                   name="day_end"
                   placeholder="To:"
                   value="@if($request->has("day_end")) {{ $request->day_end }} @endif"
            >
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
        <div class="col-sm-2 input-group ">
            <select class="form-control" name="client_id">
                <option value="0">All Clients</option>
                @foreach(\App\DataClient::all() as $client)
                    <option value="{{ $client->id }}"
                            @if($request->has("client_id") && $request->client_id == $client->id)
                                selected
                            @endif
                    >
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>

        </div>
        <div class="col-sm-2 input-group ">
            <button class="btn btn-default" type="submit">Report</button>
        </div>
    </form>
</div>

<script>
    $( function() {
        var opts = {
            dateFormat: "yy-mm-dd",
            firstDay: 1
        };


        $( ".datepicker" ).datepicker(opts);
    } );
</script>

<table class="table statistics table-hover report-table">
    <thead>
        <tr>
            <th rowspan="2">Day</th>
            <th rowspan="2">Client</th>
            <th colspan="3">Requests</th>
            <th colspan="5">Responses</th>
        </tr>
        <tr>
            <th>Total</th>
            <th>Unique</th>
            <th>Error</th>

            <th>Total</th>
            <th>Unique</th>
            <th>Filled</th>
            <th>Unique Filled</th>
            <th>Error</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stat as $row)
            <tr>
                <td>{{ \App\Statistics::from_days($row->day) }}</td>
                <td>
                    @if(isset($row->client_id))
                        <a href="/clients/{{ $row->client_id }}">{{ \App\DataClient::find($row->client_id)->name }}</a></td>
                    @else
                        All Clients
                    @endif
                <td>{{ $row->request_count }}</td>
                <td>{{ $row->request_unique_count }}</td>
                <td>{{ $row->error_request_count }}</td>
                <td>{{ $row->response_count }}</td>
                <td>{{ $row->unique_response_count }}</td>
                <td>{{ $row->filled_response_count }}</td>
                <td>{{ $row->unique_filled_response_count }}</td>
                <td>{{ $row->error_response_count }}</td>
            </tr>

            @php
                foreach(\App\DataRequestStat::$incrementers as $inc => $i)
                {
                    $total[$inc] += $row->$inc;
                }
            @endphp


        @endforeach

        <tr>
            <td></td>
            <td><b>Total:</b></td>
            <td><b>{{ $total["request_count"] }}</b></td>
            <td><b> - </b></td>
            <td><b>{{ $total["error_request_count"] }}</b></td>
            <td><b>{{ $total["response_count"] }}</b></td>
            <td><b> - </b></td>
            <td><b>{{ $total["filled_response_count"] }}</b></td>
            <td><b> - </b></td>
            <td><b>{{ $total["error_response_count"] }}</b></td>
        </tr>
    </tbody>
</table>


@endsection