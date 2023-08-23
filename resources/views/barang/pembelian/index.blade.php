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
                <table class="table table-bordered" id="tablePembelian">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Supplier</th>
                            <th>Status Permintaan</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status Pembelian</th>
                            <th>Aksi</th>
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
                        <label for="kode_pembelian" class="form-label">Kode Pembelian*</label>
                        <input type="text" class="form-control" name="kode_pembelian" id="kode_pembelian" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier*</label>
                        <select class="form-select" name="supplier_id" id="supplier_id">
                            @foreach ($supplier as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang_list" class="form-label">Barang*</label>
                        <select class="form-select" name="barang_list" id="barang_list" data-placeholder="Pilih Barang"
                            multiple>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
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
                            <table class="table table-sm table-bordered" id="tablePembelianDetail">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'keuangan')
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
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">Status Pembelian</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="diterima"
                                                id="diterima">
                                            <label class="form-check-label" for="diterima">
                                                Centang jika barang pembelian telah diterima
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
    {{-- https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js
https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js
https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js
https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js
https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js
https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js --}}

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js">
        < /scrip> <
        script >
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
            let table = $('#tablePembelian').DataTable({
                processing: true,
                serverSide: true,
                // Pdf download,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        className: 'btn btn-sm btn-danger',
                        filename: 'Laporan Data Pembelian',
                        title: 'Laporan Data Pembelian',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        customize: function(doc) {
                            doc.styles.title = {
                                color: 'black',
                                fontSize: '20',
                                alignment: 'center'
                            };
                            doc.content.splice(0, 0, {
                                margin: [-12, 0, 0, 12],
                                alignment: 'center',
                                image: "data:image/png;base64,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"
                            }, );
                        },
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-sm btn-success',
                        filename: 'Data Pembelian',
                        title: 'Data Pembelian',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-sm btn-warning',
                        filename: 'Data Pembelian',
                        title: 'Data Pembelian',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                    },
                ],
                ajax: "{{ route('pembelian.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_pembelian',
                        name: 'kode_pembelian'
                    },
                    {
                        data: 'supplier_id',
                        name: 'supplier_id'
                    },
                    {
                        data: 'status_permintaan',
                        name: 'status_permintaan'
                    },
                    {
                        data: 'tanggal_permintaan',
                        name: 'tanggal_permintaan'
                    },
                    {
                        data: 'status_pembelian',
                        name: 'status_pembelian'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#barang_list').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
            });

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
                                            <td><input type="number" class="form-control form-control-sm" name="jumlah" value="${data.data.eoq}" id="jumlah_${data.data.id}" readonly></td>
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
                    formData.append('kode_pembelian', $('#kode_pembelian').val());
                    formData.append('supplier_id', $('#supplier_id').val());
                    formData.append('list_barang', JSON.stringify(listBarang));

                    let url = "{{ route('pembelian.store') }}";
                    let method = "POST";
                    if (btn == "Update") {
                        url = "{{ url('pembelian') }}" + '/' + idUpdate;
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
                    url: "{{ route('pembelian.generate_kode') }}",
                    type: "GET",
                    success: function(response) {
                        $('#kode_pembelian').val(response.kode);
                    }
                });
            });

            $(document).on('click', '#btnSimpanDetail', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Konfirmasi pembelian barang ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $('#id_detail').val();
                        url = "{{ url('pembelian') }}" + '/' + id;

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

            $(document).on('click', '.btnDetail', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#tablePembelianDetail tbody').empty();
                $('#tablePembelianDetail tfoot').empty();
                $.ajax({
                    url: "{{ url('pembelian') }}" + '/' + id,
                    type: "GET",
                    success: function(response) {
                        let total = 0;
                        $('#id_detail').val(response.data.id);
                        response.data.pembelian_detail.map((item, index) => {
                            $('#tablePembelianDetail tbody').append(`
                                <tr>
                                    <td>${item.barang.kode_barang}</td>
                                    <td>${item.barang.nama_barang}</td>
                                    <td>${formatRupiah(item.jumlah,'')}</td>
                                    <td>${formatRupiah(item.harga_satuan,'')}</td>
                                    <td>${formatRupiah(item.harga_total,'')}</td>
                                </tr>
                            `);
                            total += item.harga_total;
                        });
                        $('#tablePembelianDetail tfoot').append(`
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th>${formatRupiah(total,'')}</th>
                            </tr>
                        `);

                        $('#status_permintaan_terima').prop('checked', response.data
                            .status_permintaan == 1 ? true : false);
                        $('#status_permintaan_tolak').prop('checked', response.data
                            .status_permintaan == 2 ? true : false);

                        if (response.data.status_permintaan != 0) {
                            $('#status_permintaan_terima').prop('disabled', true);
                            $('#status_permintaan_tolak').prop('disabled', true);
                            $('#btnSimpanDetail').prop('hidden', true);
                        } else {
                            $('#status_permintaan_terima').prop('disabled', false);
                            $('#status_permintaan_tolak').prop('disabled', false);
                            $('#btnSimpanDetail').prop('hidden', false);
                        }

                        if (response.data.status_pembelian == 1) {
                            $('#diterima').prop('checked', true);
                            $('#diterima').prop('disabled', true);
                        } else {
                            if (response.data.status_permintaan == 0 || response.data
                                .status_permintaan == 2) {
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
