@extends('adminlte::page')

@section('title', 'Template Surat')

@section('content_header')
    <h1>Template Surat</h1>
@stop

@section('content')
    <a href="{{ route('dashboard.templates.create') }}" class="btn btn-primary">Create New Template</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($templates as $template)
                <tr>
                    <td>{{ $template->title }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $template->content) }}">view file</a>
                    </td>

                    <td>
                        <a href="{{ route('dashboard.templates.edit', $template->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('dashboard.templates.destroy', $template->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this template?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
