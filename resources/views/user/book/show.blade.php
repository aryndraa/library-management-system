@extends('layouts.show', ['routeDirect' => 'member.book.index'])

@section('content')
    @livewire('book-detail', ['book' => $book])
@endsection
