{{--@section('content')--}}
<h3>Menu Items List</h3>
<table border="1">
    @foreach($data_clients as $client)
        <tr>
            <td>{{$client->id}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->token}}</td>
            <td>
                @if($client->status == 1)
                    <b color="green">active</b>
                @else
                    <b color="red">disabled</b>
                @endif
            </td>
            <td>{{$client->created_at}}</td>
            <td>{{$client->updated_at}}</td>
            <td>
                {{$client->contact_name}}<br/>
                {{$client->contact_email}}<br/>
                {{$client->contact_phone}}<br/>
            </td>
            <td>
                <a href = "/data_clients/{{$client->id}}">
                    <button>Edit</button>
                </a>
            </td>
            <td>
                <form method="POST" action="/data_clients/{{$client->id}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Delete</button>
                </form>

            </td>
        </tr>
    @endforeach
</table>

<form method="POST" action="data_clients">
    {{csrf_field()}}
    <button type="submit">Create NEW</button>
</form>
{{--@endsection--}}