@extends('adminlte::page')

@section('title', 'Template Surat')

@section('content_header')
    <h1>Template Surat</h1>
@stop

@section('content')
    <a href="{{ route('dashboard.templates.create') }}" class="btn btn-primary mb-3">Create New Template</a>
    <table id="templateTable" class="table table-bordered">
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

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> <!-- Core DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script> <!-- Bootstrap Integration -->
    <script>
        $(document).ready(function() {
            $('#templateTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                order: [
                    [0, 'asc']
                ], // Urutkan berdasarkan kolom pertama
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2] // Non-aktifkan pengurutan pada kolom "Actions"
                }]
            });
        });
    </script>

@stop
