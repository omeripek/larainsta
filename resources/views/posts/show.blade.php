@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-8">
			<img src="{{ url('/storage/') }}/{{ $post->image }}" class="w-100">
		</div>
		<div class="col-4">
			<div>
				<div class="d-flex align-items-center">
					<div class="pr-3">
						<img src="{{ $post->user->profile->profileImage() }}" alt="{{ $post->user->name }} Profile Image" class="rounded-circle w-100" style="max-width: 40px;">
					</div>
					<div>
						<div class="font-weight-bold"><a href="{{ url('profile') }}/{{ $post->user->id }}" class="text-dark">{{ $post->user->username }}</a>
						<a href="#" class="pl-3">Follow</a>
						</div>
					</div>
				</div>
				<hr>
				<p> <span class="font-weight-bold"><a href="{{ url('profile') }}/{{ $post->user->id }}" class="text-dark">{{ $post->user->username }}</a></span> {{ $post->caption }}</p>
			</div>
		</div>
	</div>
</div>
@endsection