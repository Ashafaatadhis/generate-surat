@extends('adminlte::page')

@section('title', 'Create Link')

@section('content_header')
    <h1>Create Link</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.links.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="unique_code_link">Unique Code Link</label>
            <input type="text" name="unique_kode_link" id="unique_code_link" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quota">Quota</label>
            <input type="number" name="kuota" id="quota" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop
