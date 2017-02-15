@extends('layouts.main')

@section('content')
<h3>C8 Data Buyers</h3>
<table class="table clients table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Token</th>
            <th>Status</th>
            <th>Create Time</th>
            <th>Change Time</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data_clients as $client)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->token}}</td>
            <td>
                @if($client->status == \App\DataClient::ON)
                    <b style="color:green;">active</b>
                @else
                    <b style="color:red;">disabled</b>
                @endif
            </td>
            <td>{{$client->created_at}}</td>
            <td>{{$client->updated_at}}</td>
            <td>
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{$client->contact_name}}<br/>
                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {{$client->contact_email}}<br/>
                <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span> {{$client->contact_phone}}<br/>
            </td>
            <td>
                <a href = "/clients/{{$client->id}}">
                    <button class="btn btn-info">Edit</button>
                </a>
            </td>
            <td>
                <form method="POST" action="/clients/{{$client->id}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<form method="POST" action="clients">
    {{csrf_field()}}
    <button type="submit" class="btn btn-success">Create NEW</button>
</form>
@endsection