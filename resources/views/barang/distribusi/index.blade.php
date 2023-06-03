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
                <table class="table table-bordered" id="tableDistribusi">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Permintaan</th>
                            <th>Barang</th>
                            <th>Keterangan</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
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
                        <label for="permintaan_id" class="form-label">Kode Permintaan*</label>
                        <select class="form-control" name="permintaan_id" id="permintaan_id">
                            <option value="">-- Pilih Permintaan --</option>
                            @foreach ($permintaan as $item)
                                <option value="{{ $item->id }}">{{ $item->kode_permintaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang_list" class="form-label">Barang*</label>
                        <select class="form-select" name="barang_list" id="barang_list" data-placeholder="Pilih Barang"
                            multiple></select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" cols="10" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <table class="table table-sm table-bordered" id="tableBarang">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
                            Detail Pembelian
                        </div>
                        <input type="hidden" id="id_detail">
                        <div class="col-12 mt-3">
                            <table class="table table-sm table-bordered" id="tablePermintaanDetail">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'gudang')
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">Status Permintaan</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_permintaan"
                                                id="status_permintaan_terima" value="terima">
                                            <label class="form-check-label" for="status_permintaan_terima">
                                                Terima
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_permintaan"
                                                id="status_permintaan_tolak" value="tolak">
                                            <label class="form-check-label" for="status_permintaan_tolak">
                                                Tolak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-secondary" id="btnCloseDetail"
                        data-bs-dismiss="modal">Close</button>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'keuangan')
                        <button type="button" class="btn btn-primary" id="btnSimpanDetail">Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
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
            let table = $('#tableDistribusi').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('distribusi.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'permintaan_id',
                        name: 'permintaan_id'
                    },
                    {
                        data: 'barang_id',
                        name: 'barang_id'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                ]
            });

            $('#permintaan_id').on('change', function() {
                let id = $(this).val();
                if(id != "") {
                    let url = "{{ url('permintaan') }}" + '/' + id;
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            $('#barang_list').empty();
                            data.data.permintaan_detail.map(function(item) {
                                $('#barang_list').append('<option value="' + item.barang_id + '">' + item
                                    .barang.nama_barang + '</option>');
                            });
                            $('#barang_list').select2({
                                theme: "bootstrap-5",
                                width: $(this).data('width') ? $(this).data('width') : $(
                                    this).hasClass('w-100') ? '100%' : 'style',
                                placeholder: $(this).data('placeholder'),
                                closeOnSelect: false,
                            });
                        }
                    })
                }
            });

            // $('#barang_list').select2({
            //     theme: "bootstrap-5",
            //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
            //         'style',
            //     placeholder: $(this).data('placeholder'),
            //     closeOnSelect: false,
            // });

            $('#barang_list').on('select2:select select2:unselect', function(e) {
                let ids = $(this).val();
                $('#tableBarang tbody').empty();
                ids.map(function(id) {
                    let url = "{{ url('barang') }}" + '/' + id;
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            let html = `<tr>
                                            <td>${data.data.id}</td>
                                            <td>${data.data.kode_barang}</td>
                                            <td>${data.data.nama_barang}</td>
                                            <td>${data.data.harga_beli}</td>
                                            <td><input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah_${data.data.id}"></td>
                                        </tr>`;
                            $('#tableBarang tbody').append(html);
                        }
                    });
                });
            });

            $('#btnSimpan').click(function() {
                if (validate()) {
                    $('#btnSimpan').html('Loading...');

                    let listBarang = [];
                    $('#tableBarang tbody tr').each(function() {
                        let id = $(this).find('td').eq(0).text();
                        let jumlah = $(this).find('input').val();
                        listBarang.push({
                            id: id,
                            jumlah: jumlah
                        });
                    });
                    let formData = new FormData();
                    formData.append('permintaan_id', $('#permintaan_id').val());
                    formData.append('keterangan', $('#keterangan').val());
                    formData.append('list_barang', JSON.stringify(listBarang));

                    let url = "{{ route('distribusi.store') }}";
                    let method = "POST";
                    if (btn == "Update") {
                        url = "{{ url('distribusi') }}" + '/' + idUpdate;
                        method = "PUT";
                    }
                    if (method == "PUT") {
                        formData.append('_method', 'PUT');
                    }
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
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

                $.ajax({
                    url: "{{ route('permintaan.generate_kode') }}",
                    type: "GET",
                    success: function(response) {
                        $('#kode_permintaan').val(response.kode);
                    }
                });
            });

            $(document).on('click', '#btnSimpanDetail', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Konfirmasi permintaan barang ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $('#id_detail').val();
                        url = "{{ url('permintaan') }}" + '/' + id;

                        let formData = new FormData();
                        formData.append('status_permintaan', $(
                            'input[name="status_permintaan"]:checked').val());
                        formData.append('_method', 'PUT');
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                $('#btnSimpanDetail').html('Simpan');
                                $('#modalDetail').modal('hide');
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
                            url: "{{ url('barang') }}" + '/' + id,
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
            $('body').on('click', '.btnStatus', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('pembelian') }}" + '/' + id,
                    type: "GET",
                    success: function(response) {
                        $('#id_detail').val(response.id);
                        $('#modalDetail').modal('show');
                    }
                });
            });

            $('#diterima').click(function() {
                if ($(this).is(':checked')) {
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Konfirmasi penerimaan pembelian barang ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, konfirmasi!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('pembelian.confirm_barang') }}",
                                type: "POST",
                                data: {
                                    id: $('#id_detail').val()
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#modalDetail').modal('hide');
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
                        } else {
                            $('#diterima').prop('checked', false);
                        }
                    });
                }
            })

            $(document).on('click', '.btnStatus', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#tablePermintaanDetail tbody').empty();
                $('#tablePermintaanDetail tfoot').empty();
                $.ajax({
                    url: "{{ url('permintaan') }}" + '/' + id,
                    type: "GET",
                    success: function(response) {
                        let total = 0;
                        $('#id_detail').val(response.data.id);
                        response.data.permintaan_detail.map((item, index) => {
                            $('#tablePermintaanDetail tbody').append(`
                                <tr>
                                    <td>${item.barang.kode_barang}</td>
                                    <td>${item.barang.nama_barang}</td>
                                    <td>${formatRupiah(item.jumlah,'')}</td>
                                </tr>
                            `);
                        });

                        $('#status_permintaan_terima').prop('checked', response.data
                            .status == 1 ? true : false);
                        $('#status_permintaan_tolak').prop('checked', response.data
                            .status == 2 ? true : false);

                        if (response.data.status != 0) {
                            $('#status_permintaan_terima').prop('disabled', true);
                            $('#status_permintaan_tolak').prop('disabled', true);
                            $('#btnSimpanDetail').prop('hidden', true);
                        } else {
                            $('#status_permintaan_terima').prop('disabled', false);
                            $('#status_permintaan_tolak').prop('disabled', false);
                            $('#btnSimpanDetail').prop('hidden', false);
                        }

                        if (response.data.status == 1) {
                            $('#diterima').prop('checked', true);
                            $('#diterima').prop('disabled', true);
                        } else {
                            if (response.data.status == 0 || response.data.status == 2) {
                                $('#diterima').prop('checked', false);
                                $('#diterima').prop('disabled', true);
                            } else {
                                $('#diterima').prop('checked', false);
                                $('#diterima').prop('disabled', false);
                            }
                        }
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
            let valid = true;
            if ($('#supplier_id').val() == '') {
                valid = false;
                $('#supplier_id').addClass('is-invalid');
            } else {
                valid = true;
                $('#supplier_id').removeClass('is-invalid');
            }
            if ($('#barang_list').val() == '') {
                valid = false;
                $('#barang_list').addClass('is-invalid');
            } else {
                valid = true;
                $('#barang_list').removeClass('is-invalid');
            }
            return valid;
        }

        function clear() {
            $('#supplier_id').val('');
            $('#barang_list').val([]).change();
            $('#tableBarang tbody').html('');
            $('#btnSimpan').html('Simpan');
        }

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            angka = angka.toString();
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>
@endsection
