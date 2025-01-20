@extends('layouts.app')

@section('title', 'Edit Template Surat')

@section('content')
    <div class="container">
        <h2>Edit Template</h2>
        <form action="{{ route('dashboard.templates.update', $template->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Input nama template -->
            <div class="mb-3">
                <label for="name" class="form-label">Template Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $template->title) }}" required>
            </div>

            <!-- Input file template -->
            <div class="mb-3">
                <label for="file" class="form-label">Upload Template (DOCX)</label>
                <input type="file" class="form-control" id="file" name="file" accept=".docx">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Template</button>
            </div>
        </form>

        <form action="{{ route('dashboard.templates.destroy', $template->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Template</button>
        </form>
    </div>
@endsection
