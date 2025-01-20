@extends('layouts.app')

@section('title', 'Generate Template')

@section('content')
    <div class="container pt-3">
        <h2>Choose a Template and Fill in Your Datas</h2>

        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('guest.store') }}" method="POST">
            @csrf


            <div id="dynamic-inputs"></div> <!-- Tempat untuk input dinamis -->

            <div class="form-group">
                <label for="template_id">Select Template</label>
                <select id="template_id" name="template_id" class="form-control" required>
                    <option value="" disabled selected>-- Choose a Template --</option>
                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->title }}</option>
                    @endforeach
                </select>
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script>
        document.getElementById('template_id').addEventListener('change', function() {
            const templateId = this.value;

            if (templateId) {
                // Hapus input sebelumnya
                const dynamicInputs = document.getElementById('dynamic-inputs');
                dynamicInputs.innerHTML = '';

                // Ambil variabel template dari server
                fetch(`/template-variables/${templateId}`)
                    .then(response => response.json())
                    .then(variables => {
                        variables.forEach(variable => {
                            // Buat input baru untuk setiap variabel
                            const inputGroup = document.createElement('div');
                            inputGroup.classList.add('form-group');

                            const label = document.createElement('label');

                            // regex untuk mereplace, misal nama_mahasiswa jadi Nama Mahasiswa
                            label.innerText = variable.replace(/_/g, ' ').replace(/\w\S*/g, (txt) => txt
                                .charAt(0).toUpperCase() + txt.substr(1).toLowerCase());


                            const input = document.createElement('input');
                            input.type = 'text';
                            input.name = variable;
                            input.classList.add('form-control');

                            inputGroup.appendChild(label);
                            inputGroup.appendChild(input);
                            dynamicInputs.appendChild(inputGroup);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
