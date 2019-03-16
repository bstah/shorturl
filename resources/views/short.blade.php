@extends('layout')


@section('content')

<h1>Short URL Creator</h1>
<form method="POST" action='/'>
	{{ csrf_field() }}
	<div class="mb-3">
		<input type="text" name="longurl" style="width: 500px;">
		<input type="submit" name="" class="btn btn-primary"><br>
		@isset($error)
		<div class="alert alert-danger" role="alert">
			{{ $error }}
		</div>
		@endisset
	</div>
	
</form>
@isset($shorturl)
	<p>Your short url: <a href="{{ $shorturl }}" target="_blank">{{ $shorturl }}</a></p>
@endisset


@endsection
