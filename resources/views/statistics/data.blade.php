@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3>Demanded Data Statistics</h3>
</div>
<div class="container report-params">
    <form action="{{ route('data_statistics') }}" method="POST">
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
            <select class="form-control" name="dmp_id">
                <option value="0">All DMP</option>
                @foreach(\App\DMP::all() as $dmp)
                    <option value="{{ $dmp->dmp_id }}"
                            @if($request->has("dmp_id") && $request->dmp_id == $dmp->dmp_id)
                                selected
                            @endif
                    >
                        {{ $dmp->name }}
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
            <th>Day</th>
            <th>Client</th>
            <th>DMP</th>
            <th>Taxonomy</th>
            <th>Hits</th>
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
                <td>{{ \App\DMP::find($row->dmp_id)->name }}</td>
                <td>{{ \App\Taxonomy::getDmpTaxonomy($row->dmp_id, $row->tax_id)->text }}</td>
                <td>{{ $row->hit }}</td>
            </tr>
        @endforeach


    </tbody>
</table>


@endsection