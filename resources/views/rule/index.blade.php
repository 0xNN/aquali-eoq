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
                <table class="table table-bordered" id="tableRule">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Biaya Pemesanan</th>
                            <th>Biaya Penyimpanan</th>
                            <th>Lead Time</th>
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
                        <label for="biaya_pemesanan" class="form-label">Biaya Pemesanan*</label>
                        <input type="number" class="form-control" name="biaya_pemesanan" id="biaya_pemesanan" placeholder="Masukan Biaya Pemesanan">
                    </div>
                    <div class="mb-3">
                        <label for="biaya_penyimpanan" class="form-label">Biaya Penyimpanan*</label>
                        <input type="number" class="form-control" name="biaya_penyimpanan" id="biaya_penyimpanan" placeholder="Masukan Biaya Penyimpanan">
                    </div>
                    <div class="mb-3">
                        <label for="lead_time" class="form-label">Lead Time*</label>
                        <input type="number" class="form-control" name="lead_time" id="lead_time" placeholder="Masukan Lead Time">
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
            let table = $('#tableRule').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rule.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'biaya_pemesanan',
                        name: 'biaya_pemesanan'
                    },
                    {
                        data: 'biaya_penyimpanan',
                        name: 'biaya_penyimpanan'
                    },
                    {
                        data: 'lead_time',
                        name: 'lead_time'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            $('#btnSimpan').click(function() {
                if (validate()) {
                    $('#btnSimpan').html('Loading...');
                    let url = "{{ route('rule.store') }}";
                    let method = "POST";
                    if (btn == "Update") {
                        url = "rule/" + idUpdate;
                        method = "PUT";
                    }
                    let data = {
                        biaya_pemesanan: $('#biaya_pemesanan').val(),
                        biaya_penyimpanan: $('#biaya_penyimpanan').val(),
                        lead_time: $('#lead_time').val(),
                    };
                    $.ajax({
                        url: url,
                        type: method,
                        data: data,
                        dataType: 'JSON',
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
                }
            });

            $('#btnClose').click(function() {
                clear();
                $('#btnSimpan').html('Simpan');
                btn = "Simpan";
            });

            $('#btnAdd').click(function() {
                clear();
                $('#btnSimpan').html('Simpan');
                btn = "Simpan";
            });

            $(document).on('click', '.btnEdit', function(e) {
                e.preventDefault();
                btn = "Update";
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('rule') }}" + '/' + id + '/edit',
                    type: "GET",
                    success: function(response) {
                        $('#biaya_pemesanan').val(response.data.biaya_pemesanan);
                        $('#biaya_penyimpanan').val(response.data.biaya_penyimpanan);
                        $('#lead_time').val(response.data.lead_time);
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
                            url: "{{ url('rule') }}" + '/' + id,
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

        const validate = () => {
            let biaya_pemesanan = $('#biaya_pemesanan').val();
            let biaya_penyimpanan = $('#biaya_penyimpanan').val();
            let lead_time = $('#lead_time').val();
            if (biaya_pemesanan == '') {
                $('#biaya_pemesanan').addClass('is-invalid');
                return false;
            } else {
                $('#biaya_pemesanan').removeClass('is-invalid')
            }
            if (biaya_penyimpanan == '') {
                $('#biaya_penyimpanan').addClass('is-invalid');
                return false;
            } else {
                $('#biaya_penyimpanan').removeClass('is-invalid')
            }
            if (lead_time == '') {
                $('#lead_time').addClass('is-invalid');
                return false;
            } else {
                $('#lead_time').removeClass('is-invalid')
            }
            return true;
        }

        function clear() {
            $('#biaya_pemesanan').val('');
            $('#biaya_penyimpanan').val('');
            $('#lead_time').val('');
        }
    </script>
@endsection
