@extends('adminlte::page')

@section('title', 'Links')

@section('content_header')
    <h1>Links</h1>
@stop

@section('content')
    <a href="{{ route('dashboard.links.create') }}" class="btn btn-primary mb-3">Create New Link</a>
    <table id="linkTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Link</th>
                <th>Quota (Remaining)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($links as $link)
                <tr>
                    <td>
                        <span id="link-{{ $link->id }}">{{ env('APP_URL') . '/link/' . $link->unique_kode_link }}</span>
                    </td>
                    <td>{{ $link->kuota }}</td>
                    <td>
                        <a href="{{ route('dashboard.links.edit', $link->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('dashboard.links.destroy', $link->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this link?')">Delete</button>
                        </form>
                        <button class="btn btn-secondary" onclick="copyToClipboard('{{ $link->id }}')">Copy</button>
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
            $('#linkTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                order: [
                    [0, 'asc']
                ], // Urutkan berdasarkan kolom pertama
                columnDefs: [{
                    orderable: false,
                    targets: [2] // Non-aktifkan pengurutan pada kolom "Actions"
                }]
            });
        });
    </script>
    <script>
        function copyToClipboard(id) {
            const linkText = document.getElementById('link-' + id).textContent;
            navigator.clipboard.writeText(linkText)
                .then(() => {
                    alert('Link copied to clipboard!');
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
        }
    </script>

@stop
