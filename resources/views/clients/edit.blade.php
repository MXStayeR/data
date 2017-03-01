@extends('layouts.main')

@section('content')

<div class="page-header col-sm-offset-1">
    @if(empty($client->name))
        <h1>Creating of a new client</h1>
    @else
        <h1>Settings of "{{$client->name}}"</h1>
    @endif
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/clients/{{$client->id}}" class="form-horizontal">
    <div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="page-header col-sm-offset-1">
            <h3>Main settings</h3>
        </div>
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$client->id}}">

        <div class="form-group">
            <label class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" name="name" class="form-control" value="{{$client->name}}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Token</label>
            <div class="col-sm-8">
                <input type="text" name="token" class="form-control" value="{{$client->token}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <label>
                <select name="status" class="form-control">
                    <option   value="{{\App\DataClient::OFF}}" @if($client->status == \App\DataClient::OFF) selected @endif>Disabled</option>
                    <option  value="{{\App\DataClient::ON}}" @if($client->status == \App\DataClient::ON) selected @endif>Enabled</option>
                </select>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Contact Person</label>
            <div class="col-sm-8">
                <input type="text" name="contact_name" class="form-control" value="{{$client->contact_name}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Contact E-mail</label>
            <div class="col-sm-8">
                <input type="text" name="contact_email" class="form-control" value="{{$client->contact_email}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Contact Phone</label>
            <div class="col-sm-8">
                <input type="text" name="contact_phone" class="form-control" value="{{$client->contact_phone}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Security Type</label>
            <div class="col-sm-8">
                <select name="security_type" class="form-control">
                    <option value="ip" @if( $client->security_type == "ip" ) selected @endif >IP Addresses</option>
                    <option value="referrer" @if( $client->security_type == "referrer" ) selected @endif >Referrers</option>
                    {{--<option value="user_agent" @if( $client->security_type == "user_agent" ) selected @endif >User Agents</option>--}}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Security Entities</label>
            <div class="col-sm-8">
                @php $type = $client->security_type; @endphp
                <textarea name="security" class="form-control" rows="{{count($security) > 5 ? count($security) : 5}}">@foreach($security as $row){{"\r".$row->$type}}@endforeach</textarea>
            </div>
        </div>

        <div class="page-header col-sm-offset-1">
            <h3>Limits</h3>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Requests</label>
            <div class="col-sm-8">
                <input type="text" name="limit_request" class="form-control" value="{{$client->limit_request}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Unique Requests</label>
            <div class="col-sm-8">
                <input type="text" name="limit_unique_request" class="form-control" value="{{$client->limit_unique_request}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Responses</label>
            <div class="col-sm-8">
                <input type="text" name="limit_response" class="form-control" value="{{$client->limit_response}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Unique Responses</label>
            <div class="col-sm-8">
                <input type="text" name="limit_unique_response" class="form-control" value="{{$client->limit_unique_response}}">
            </div>
        </div>



    </div>
    <div class="col-md-5 col-sm-12 col-md-offset-1">
        <div class="page-header col-sm-offset-1">
            <h3>Allowed DMP data</h3>
        </div>
        @foreach($dmps as $dmp)
            <div class="form-group">

                <div class="col-sm-offset-2 col-sm-8 checkbox">
                    <label>
                        <input type="checkbox" name="allowed_dmp[]" value="{{$dmp->dmp_id}}" @if( $client->hasDMP($dmp->dmp_id) ) checked @endif>
                        {{$dmp->name}}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    </div>
    <div class="col-sm-offset-2">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</form>

@endsection