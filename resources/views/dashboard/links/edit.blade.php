@extends('adminlte::page')

@section('title', 'Edit Link')

@section('content_header')
    <h1>Edit Link</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.links.update', $link->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="unique_code_link">Unique Code Link</label>
            <input type="text" name="unique_kode_link" id="unique_code_link" class="form-control"
                value="{{ $link->unique_kode_link }}" required>
        </div>
        <div class="form-group">
            <label for="quota">Quota</label>
            <input type="number" name="kuota" id="quota" class="form-control" value="{{ $link->kuota }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@stop
