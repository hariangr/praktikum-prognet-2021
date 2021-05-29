@extends('layout')

@section('page-contents')
    {{ $review }}

    {{ $adminResponse }}

    <form action="{{ route('replyReview', $review->id) }}" method="POST">
        @csrf
        <input type="hidden" name="review_id" value="{{ $review->id }}">
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <button>Response</button>
    </form>
@endsection
