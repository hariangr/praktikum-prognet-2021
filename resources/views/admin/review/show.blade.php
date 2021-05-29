@extends('layout')

@section('page-contents')
    {{ $product }}

    {{ $review }}

    {{ $adminResponse }}

    @if ($review != null)
        <form action="{{ route('replyReview', $review->id) }}" method="POST">
            @csrf
            <input type="hidden" name="review_id" value="{{ $review->id }}">
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
            <button>Response</button>
        </form>
    @else
        <p>Belum ada review</p>
    @endif
@endsection
