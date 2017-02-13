{{--@section('content')--}}

    <form method="POST" action="/data_clients/{{$client->id}}">
        <table border="1">

            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$client->id}}">
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="{{$client->name}}"></td>
            </tr>
            <tr>
                <td>Token</td>
                <td><input type="text" name="token" value="{{$client->token}}"></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if($client->status == 1)
                        <b color="green">active</b>
                    @else
                        <b color="red">disabled</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Contact Name</td>
                <td><input type="text" name="contact_name" value="{{$client->contact_name}}"></td>
            </tr>
            <tr>
                <td>Contact E-Mail</td>
                <td><input type="text" name="contact_email" value="{{$client->contact_email}}"></td>
            </tr>
            <tr>
                <td>Contact Phone</td>
                <td><input type="text" name="contact_phone" value="{{$client->contact_phone}}"></td>
            </tr>


            <tr>
                <td>Security Type</td>
                <td>
                    <select name="security_type" >
                        <option value="ip" @if( $client->security_type == "ip" ) selected @endif >IP Addresses</option>
                        <option value="referrer" @if( $client->security_type == "referrer" ) selected @endif >Referrers</option>
                        <option value="user_agent" @if( $client->security_type == "user_agent" ) selected @endif >User Agents</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Security List</td>
                <td>
                    <textarea name="security">
                        @foreach($security as $row)
                            {{$row->ip}}
                        @endforeach
                    </textarea>

                </td>
            </tr>
        </table>
        <button type="submit">Save</button>

    </form>
<a href="/data_clients">
    <button>Back</button>
</a>

{{--@endsection--}}