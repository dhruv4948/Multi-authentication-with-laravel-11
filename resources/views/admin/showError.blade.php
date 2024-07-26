<!-- resources/views/cs/show.blade.php -->

@extends('layouts.app')

@section('content')
@foreach ($err as $c)
    <div class="container">
        <h1>c Details</h1>
        <p><strong>Stored Path:</strong> {{ $c->stored_path }}</p>
        <p><strong>Table Type:</strong> {{ $c->table_type }}</p>
        <p><strong>Status:</strong> {{ $c->status }}</p>
        @if ($c->status == 'Failed')
            <p><strong>Error Message:</strong> Failed to process the File . Please check the logs for more details.</p>
        @endif
        <a href="" class="btn btn-primary">Back</a>
    </div>
@endforeach
@endsection