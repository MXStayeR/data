@extends("layouts.main")

@section("content")
    @if (Auth::guest())
    <div class="jumbotron">
        <h1>C8 Data Sales</h1>
        <p>You are welcome at C8 Data Sales admin panel!<br/>You have to login to learn statistics or to tune any client </p>
        <p><a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Login now</a></p>
    </div>
    @endif
@endsection