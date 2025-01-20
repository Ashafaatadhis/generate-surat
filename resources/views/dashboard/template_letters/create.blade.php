@extends('adminlte::page')

@section('title', 'Create Template')

@section('content_header')
    <h1>Create Template</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.templates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Template Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="file">Upload Word Document</label>
            <input type="file" name="file" class="form-control" accept=".docx" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save Template</button>
        </div>
    </form>
@stop
