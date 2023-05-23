@extends('layouts.home')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-sm btn-success" id="btnAdd" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>EOQ</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary" role="alert">
                        <strong>Perhatian!</strong> Form yang bertanda (*) wajib diisi.
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Barang*</label>
                        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori"
                            placeholder="Masukan Kategori Barang">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="is_eoq">
                        <label class="form-check-label" for="is_eoq" name="is_eoq">
                            EOQ
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnClose" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            let btn = "Simpan";
            let idUpdate = null;
            let table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kategori.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
                    },
                    {
                        data: 'is_eoq',
                        name: 'is_eoq'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#btnSimpan').click(function() {
                $('#btnSimpan').html('Loading...');
                let nama_kategori = $('#nama_kategori').val();
                let is_eoq = $('#is_eoq').is(':checked');
                let url = "{{ route('kategori.store') }}";
                let method = "POST";
                if (btn == "Update") {
                    url = "{{ url('kategori') }}" + '/' + idUpdate;
                    method = "PUT";
                }
                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        nama_kategori: nama_kategori,
                        is_eoq: is_eoq,
                    },
                    success: function(response) {
                        $('#btnSimpan').html('Simpan');
                        $('#exampleModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        table.ajax.reload();
                    },
                    error: function(response) {
                        $('#btnSimpan').html('Simpan');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        });
                    }
                });
            });

            $('#btnClose').click(function() {
                $('#nama_kategori').val('');
                $('#btnSimpan').html('Simpan');
                btn = "Simpan";
            });

            $('#btnAdd').click(function() {
                $('#nama_kategori').val('');
                $('#btnSimpan').html('Simpan');
                btn = "Simpan";
            });

            $(document).on('click', '.btnEdit', function(e) {
                e.preventDefault();
                btn = "Update";
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('kategori') }}" + '/' + id + '/edit',
                    type: "GET",
                    success: function(response) {
                        $('#nama_kategori').val(response.data.nama_kategori);
                        $('#is_eoq').prop('checked', response.data.is_eoq);
                        $('#btnSimpan').html('Update');
                        $('#exampleModal').modal('show');
                        idUpdate = response.data.id;
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        });
                    }
                });
            });

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('kategori') }}" + '/' + id,
                            type: "DELETE",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                                table.ajax.reload();
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
