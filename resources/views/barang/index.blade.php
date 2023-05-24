@extends('layouts.home')

@section('content')
    <div class="container-fluid">
        @foreach ($barang as $item)
            @if ($item->stok <= $item->eoq)
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>{{ $item->nama_barang }}</strong> stoknya sudah di bawah EOQ, silahkan lakukan pembelian
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach
        <div class="card">
            <div class="card-header">
                <button class="btn btn-sm btn-success" id="btnAdd" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tableBarang">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            {{-- <th>Stok</th> --}}
                            <th>EOQ</th>
                            <th>EOQ (capaian)</th>
                            <th>EOQ (sisa)</th>
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
                        <label for="kode_barang" class="form-label">Kode Barang*</label>
                        <input type="text" class="form-control" name="kode_barang" id="kode_barang"
                            placeholder="Masukan Kode Barang">
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang*</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang"
                            placeholder="Masukan Nama Barang">
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori*</label>
                        <select class="form-select" name="kategori_id" id="kategori_id">
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli*</label>
                        <input type="number" class="form-control" name="harga_beli" id="harga_beli"
                            placeholder="Masukan Harga Beli">
                    </div>
                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual*</label>
                        <input type="number" class="form-control" name="harga_jual" id="harga_jual"
                            placeholder="Masukan Harga Jual">
                    </div>
                    <div class="mb-3">
                        <label for="penggunaan_tahun" class="form-label">Penggunaan Tahun*</label>
                        <input type="number" class="form-control" name="penggunaan_tahun" id="penggunaan_tahun"
                            placeholder="Masukan Penggunaan Tahun">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok*</label>
                        <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukan Stok">
                    </div>
                    <div class="mb-3">
                        <label for="safety_stok" class="form-label">Safety Stok*</label>
                        <input type="number" class="form-control" name="safety_stok" id="safety_stok" placeholder="Masukan Safety Stok">
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea type="text" class="form-control" name="keterangan" id="keterangan"></textarea>
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
                            <table class="table table-sm table-bordered" id="tableBarangDetail">
                                <tr>
                                    <th>Kode Barang</th>
                                    <td id="kode_barang_detail"></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td id="nama_barang_detail"></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td id="kategori_detail"></td>
                                </tr>
                                <tr>
                                    <th>Harga Beli</th>
                                    <td id="harga_beli_detail"></td>
                                </tr>
                                <tr>
                                    <th>Harga Jual</th>
                                    <td id="harga_jual_detail"></td>
                                </tr>
                                <tr>
                                    <th>Penggunaan Tahun</th>
                                    <td id="penggunaan_tahun_detail"></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td id="stok_detail"></td>
                                </tr>
                                <tr>
                                    <th>Economic Order Quantity (EOQ)</th>
                                    <td id="eoq_detail"></td>
                                </tr>
                                <tr>
                                    <th>Safety Stok</th>
                                    <td id="safety_stok_detail"></td>
                                </tr>
                                <tr>
                                    <th>Reorder point (ROP)</th>
                                    <td id="rop_detail"></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td id="keterangan_detail"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-secondary" id="btnCloseDetail" data-bs-dismiss="modal">Close</button>
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
            let table = $('#tableBarang').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('barang.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'kategori.nama_kategori',
                        name: 'kategori.nama_kategori'
                    },
                    // {
                    //     data: 'stok',
                    //     name: 'stok'
                    // },
                    {
                        data: 'eoq',
                        name: 'eoq'
                    },
                    {
                        data: 'eoq_capaian',
                        name: 'eoq_capaian'
                    },
                    {
                        data: 'eoq_sisa',
                        name: 'eoq_sisa'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#btnSimpan').click(function() {
                if (validate()) {
                    $('#btnSimpan').html('Loading...');
                    let formData = new FormData();
                    formData.append('kode_barang', $('#kode_barang').val());
                    formData.append('nama_barang', $('#nama_barang').val());
                    formData.append('kategori_id', $('#kategori_id').val());
                    formData.append('harga_beli', $('#harga_beli').val());
                    formData.append('harga_jual', $('#harga_jual').val());
                    formData.append('penggunaan_tahun', $('#penggunaan_tahun').val());
                    formData.append('stok', $('#stok').val());
                    // formData.append('safety_stok', $('#safety_stok').val());
                    if ($('#gambar')[0].files[0] != undefined) {
                        formData.append('gambar', $('#gambar')[0].files[0]);
                    }
                    formData.append('keterangan', $('#keterangan').val());

                    let url = "{{ route('barang.store') }}";
                    let method = "POST";
                    if (btn == "Update") {
                        url = "{{ url('barang') }}" + '/' + idUpdate;
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
            });

            $(document).on('click', '.btnEdit', function(e) {
                e.preventDefault();
                btn = "Update";
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('barang') }}" + '/' + id + '/edit',
                    type: "GET",
                    success: function(response) {
                        $('#kode_barang').val(response.data.kode_barang);
                        $('#nama_barang').val(response.data.nama_barang);
                        $('#kategori_id').val(response.data.kategori_id);
                        $('#harga_beli').val(response.data.harga_beli);
                        $('#harga_jual').val(response.data.harga_jual);
                        $('#penggunaan_tahun').val(response.data.penggunaan_tahun);
                        $('#stok').val(response.data.stok);
                        // $('#safety_stok').val(response.data.safety_stok);
                        $('#keterangan').val(response.data.keterangan);
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

            $(document).on('click', '.btnDetail', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('barang') }}" + '/' + id,
                    type: "GET",
                    success: function(response) {
                        $('#kode_barang_detail').html(response.data.kode_barang);
                        $('#nama_barang_detail').html(response.data.nama_barang);
                        $('#kategori_detail').html(response.data.kategori.nama_kategori);
                        $('#harga_beli_detail').html(response.data.harga_beli);
                        $('#harga_jual_detail').html(response.data.harga_jual);
                        $('#penggunaan_tahun_detail').html(response.data.penggunaan_tahun);
                        $('#stok_detail').html(response.data.stok);
                        $('#eoq_detail').html(`
                        <span class="badge rounded-pill bg-success">${response.data.eoq}</span>
                        `);
                        $('#safety_stok_detail').html(response.data.safety_stok);
                        $('#rop_detail').html(response.data.rop);
                        $('#keterangan_detail').html(response.data.keterangan);
                        $('#imgDetail').attr('src', "{{ asset('images/uploads') }}" + '/' + response.data.gambar);
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
            let kode_barang = $('#kode_barang').val();
            let nama_barang = $('#nama_barang').val();
            let kategori_id = $('#kategori_id').val();
            let harga_beli = $('#harga_beli').val();
            let harga_jual = $('#harga_jual').val();
            let penggunaan_tahun = $('#penggunaan_tahun').val();
            let stok = $('#stok').val();
            let safety_stok = $('#safety_stok').val();
            if (kode_barang == '') {
                $('#kode_barang').addClass('is-invalid');
                return false;
            } else {
                $('#kode_barang').removeClass('is-invalid');
            }
            if (nama_barang == '') {
                $('#nama_barang').addClass('is-invalid');
                return false;
            } else {
                $('#nama_barang').removeClass('is-invalid');
            }
            if (kategori_id == '') {
                $('#kategori_id').addClass('is-invalid');
                return false;
            } else {
                $('#kategori_id').removeClass('is-invalid');
            }
            if (harga_beli == '') {
                $('#harga_beli').addClass('is-invalid');
                return false;
            } else {
                $('#harga_beli').removeClass('is-invalid');
            }
            if (harga_jual == '') {
                $('#harga_jual').addClass('is-invalid');
                return false;
            } else {
                $('#harga_jual').removeClass('is-invalid');
            }
            if (penggunaan_tahun == '') {
                $('#penggunaan_tahun').addClass('is-invalid');
                return false;
            } else {
                $('#penggunaan_tahun').removeClass('is-invalid');
            }
            if (stok == '') {
                $('#stok').addClass('is-invalid');
                return false;
            } else {
                $('#stok').removeClass('is-invalid');
            }
            // if (safety_stok == '') {
            //     $('#safety_stok').addClass('is-invalid');
            //     return false;
            // } else {
            //     $('#safety_stok').removeClass('is-invalid');
            // }
            return true;
        }

        function clear() {
            $('#kode_barang').val('');
            $('#nama_barang').val('');
            $('#harga_beli').val('');
            $('#harga_jual').val('');
            $('#penggunaan_tahun').val('');
            $('#stok').val('');
            $('#safety_stok').val('');
            $('#gambar').val('');
            $('#keterangan').val('');
        }
    </script>
@endsection
