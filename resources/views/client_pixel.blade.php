@extends('layouts.main')

@section('content')
@php echo \App\Pixel::makeBody(\App\DataClient::find($id)); @endphp
{{--@php echo \App\Pixel::makeZeroPixel(\App\DataClient::find($id)); @endphp--}}
<div class="page-header col-sm-offset-1">
    <h1>Pixel was called</h1>
    <h3>Press F12-key to see response</h3>
</div>
@endsection
