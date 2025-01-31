@extends('layouts.app')

@section('title', 'Invalid Link')

@section('content_header')
    <h1>Link Error</h1>
@stop

@section('content')
    <div class="alert mt-4 alert-danger">
        <h4>Oops! Invalid Link</h4>
        <p>The link you are trying to access is either invalid or has run out of quota.</p>
    </div>
@stop
