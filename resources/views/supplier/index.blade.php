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
                <table class="table table-bordered" id="tableSupplier">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
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
                        <label for="nama_supplier" class="form-label">Nama Supplier*</label>
                        <input type="text" class="form-control" name="nama_supplier" id="nama_supplier"
                            placeholder="Masukan Nama Supplier">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat*</label>
                        <textarea type="text" class="form-control" name="alamat" id="alamat"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota*</label>
                        <input type="text" class="form-control" name="kota" id="kota" placeholder="Masukan Kota">
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telepon" id="telepon"
                            placeholder="Masukan Telepon">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Masukan Email">
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" id="website"
                            placeholder="Masukan Website">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnClose" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <img src="" alt="" id="imgDetail" class="img-fluid">
                        </div>
                        <div class="col-12 mt-3">
                            <table class="table table-sm table-bordered" id="tableSupplierDetail">
                                <tr>
                                    <th>Nama Supplier</th>
                                    <td id="nama_supplier_detail"></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td id="alamat_detail"></td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td id="kota_detail"></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td id="telepon_detail"></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="email_detail"></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td id="website_detail"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-secondary" id="btnCloseDetail"
                        data-bs-dismiss="modal">Close</button>
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
            let table = $('#tableSupplier').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('supplier.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_supplier',
                        name: 'nama_supplier'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'telepon',
                        name: 'telepon'
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
                    let url = "{{ route('supplier.store') }}";
                    let method = "POST";
                    if (btn == "Update") {
                        url = "supplier/" + idUpdate;
                        method = "PUT";
                    }
                    let nama_supplier = $('#nama_supplier').val();
                    let alamat = $('#alamat').val();
                    let kota = $('#kota').val();
                    let telepon = $('#telepon').val();
                    let email = $('#email').val();
                    let website = $('#website').val();
                    $.ajax({
                        url: url,
                        type: method,
                        data: {
                            nama_supplier: nama_supplier,
                            alamat: alamat,
                            kota: kota,
                            telepon: telepon,
                            email: email,
                            website: website,
                        },
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
                    url: "{{ url('supplier') }}" + '/' + id + '/edit',
                    type: "GET",
                    success: function(response) {
                        $('#nama_supplier').val(response.data.nama_supplier);
                        $('#alamat').val(response.data.alamat);
                        $('#kota').val(response.data.kota);
                        $('#telepon').val(response.data.telepon);
                        $('#email').val(response.data.email);
                        $('#website').val(response.data.website);
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
                            url: "{{ url('supplier') }}" + '/' + id,
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

            $(document).on('click', '.btnDetail', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('supplier') }}" + '/' + id,
                    type: "GET",
                    success: function(response) {
                        $('#nama_supplier_detail').html(response.data.nama_supplier);
                        $('#alamat_detail').html(response.data.alamat);
                        $('#kota_detail').html(response.data.kota);
                        $('#telepon_detail').html(response.data.telepon);
                        $('#email_detail').html(response.data.email);
                        $('#website_detail').html(response.data.website);
                        $('#modalDetail').modal('show');
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
        });

        const validate = () => {
            let nama_supplier = $('#nama_supplier').val();
            let alamat = $('#alamat').val();
            let kota = $('#kota').val();
            if (nama_supplier == '') {
                $('#nama_supplier').addClass('is-invalid')
                return false;
            } else {
                $('#nama_supplier').removeClass('is-invalid');
            }
            if (alamat == '') {
                $('#alamat').addClass('is-invalid')
                return false;
            } else {
                $('#alamat').removeClass('is-invalid');
            }
            if (kota == '') {
                $('#kota').addClass('is-invalid')
                return false;
            } else {
                $('#kota').removeClass('is-invalid');
            }
            return true;
        }

        function clear() {
            $('#nama_supplier').val('');
            $('#alamat').val('');
            $('#kota').val('');
            $('#telepon').val('');
            $('#email').val('');
            $('#website').val('');
        }
    </script>
@endsection
