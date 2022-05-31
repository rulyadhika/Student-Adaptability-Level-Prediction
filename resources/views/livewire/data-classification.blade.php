@push('pageStyle')
    <style>
        table tr th {
            min-width: 110px;
        }

    </style>
@endpush


<div>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row py-3 align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Klasifikasi</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#dataKlasifikasiModal">Tambah
                        Data</button>
                </div>
                <!-- Card Body -->
                <div class="card-body listMasukanCardBody" wire:ignore>
                    <table id="tabel-data-klasifikasi" class="display table " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th style="min-width:unset;">No</th>
                                <th>Nama</th>
                                <th>Asal Sekolah</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Pendidikan</th>
                                <th>Tipe Institusi</th>
                                <th style="min-width:120px;">Keuangan</th>
                                <th>Tipe Internet</th>
                                <th>Tipe Jaringan</th>
                                <th>Durasi Kelas</th>
                                <th>Perangkat</th>
                                <th>Nilai Prob Rendah</th>
                                <th>Nilai Prob Sedang</th>
                                <th>Nilai Prob Tinggi</th>
                                <th style="min-width:170px;">Tingkat Adaptabilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataKlasifikasi as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->asal_sekolah }}</td>
                                    <td>{{ $data->jenis_kelamin }}</td>
                                    <td>{{ $data->usia }}</td>
                                    <td>{{ $data->pendidikan }}</td>
                                    <td>{{ $data->tipe_institusi }}</td>
                                    <td>{{ $data->keadaan_keuangan }}</td>
                                    <td>{{ $data->tipe_internet }}</td>
                                    <td>{{ $data->tipe_jaringan }}</td>
                                    <td>{{ $data->durasi_kelas }}</td>
                                    <td>{{ $data->perangkat }}</td>
                                    <td style="min-width:200px;">{{ $data->nilai_prob_rendah }}</td>
                                    <td style="min-width:200px;">{{ $data->nilai_prob_sedang }}</td>
                                    <td style="min-width:200px;">{{ $data->nilai_prob_tinggi }}</td>
                                    <td>{{ $data->hasil_prediksi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="dataKlasifikasiModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="dataKlasifikasiModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataKlasifikasiModalLabel">Tambah Data Klasifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                wire:model.defer="nama">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="asal_sekolah">Asal Sekolah</label>
                            <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="asal_sekolah"
                                wire:model.defer="asal_sekolah">
                            @error('asal_sekolah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                wire:model.defer="jenis_kelamin">
                                <option>-- Pilih Jenis Kelamin --</option>
                                <option value="Boy">Laki - laki</option>
                                <option value="Girl">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usia">Usia</label>
                            <select class="form-control @error('usia') is-invalid @enderror" id="usia"
                                wire:model.defer="usia">
                                <option>-- Pilih Usia --</option>
                                <option value="1-5">1 Tahun - 5 Tahun</option>
                                <option value="6-10">6 Tahun - 10 Tahun</option>
                                <option value="11-15">11 Tahun - 15 Tahun</option>
                                <option value="16-20">16 Tahun - 20 Tahun</option>
                                <option value="21-25">21 Tahun - 25 Tahun</option>
                                <option value="26-30">26 Tahun - 30 Tahun</option>
                            </select>
                            @error('usia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pendidikan">Pendidikan</label>
                            <select class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan"
                                wire:model.defer="pendidikan">
                                <option>-- Pilih Pendidikan --</option>
                                <option value="School">Sekolah (SD,SMP,SMA)</option>
                                <option value="University">Universitas</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipe_institusi">Tipe Insitusi</label>
                            <select class="form-control @error('tipe_institusi') is-invalid @enderror" id="tipe_institusi"
                                wire:model.defer="tipe_institusi">
                                <option>-- Pilih Tipe Insitusi --</option>
                                <option value="Government">Pemerintah</option>
                                <option value="Non Government">Non Pemerintah</option>
                            </select>
                            @error('tipe_institusi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tipe_internet">Tipe Internet</label>
                            <select class="form-control @error('tipe_internet') is-invalid @enderror" id="tipe_internet"
                                wire:model.defer="tipe_internet">
                                <option>-- Pilih Tipe Internet --</option>
                                <option value="Wifi">Wifi</option>
                                <option value="Mobile Data">Paket Data</option>
                            </select>
                            @error('tipe_internet')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipe_jaringan">Tipe Jaringan</label>
                            <select class="form-control @error('tipe_jaringan') is-invalid @enderror" id="tipe_jaringan"
                                wire:model.defer="tipe_jaringan">
                                <option>-- Pilih Tipe Jaringan --</option>
                                <option value="4G">4G</option>
                                <option value="3G">3G</option>
                                <option value="2G">2G</option>
                            </select>
                            @error('tipe_jaringan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="durasi_kelas">Durasi Kelas</label>
                            <select class="form-control @error('durasi_kelas') is-invalid @enderror" id="durasi_kelas"
                                wire:model.defer="durasi_kelas">
                                <option>-- Pilih Durasi Kelas --</option>
                                <option value="1-3">1-3 Jam</option>
                                <option value="3-6">3-6 Jam</option>
                            </select>
                            @error('durasi_kelas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="perangkat">Perangkat</label>
                            <select class="form-control @error('perangkat') is-invalid @enderror" id="perangkat"
                                wire:model.defer="perangkat">
                                <option>-- Pilih Perangkat --</option>
                                <option value="Mobile">Smartphone</option>
                                <option value="Tab">Tablet</option>
                                <option value="Computer">Laptop/Komputer</option>
                            </select>
                            @error('perangkat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="keadaan_keuangan">Keadaan Keuangan</label>
                        <select class="form-control @error('keadaan_keuangan') is-invalid @enderror" id="keadaan_keuangan"
                            wire:model.defer="keadaan_keuangan">
                            <option>-- Pilih Keadaan Keuangan --</option>
                            <option value="Poor">Mengenah Kebawah</option>
                            <option value="Mid">Menengah Keatas</option>
                            <option value="Rich">Mampu</option>
                        </select>
                        @error('keadaan_keuangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="save">Tambah Data</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('pageScript')
    <script>
        const dataTablesConfig = {
            "language": {
                "emptyTable": "Belum ada data yang tersedia",
                "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "infoEmpty": "Belum ada data yang tersedia",
                "infoFiltered": "",
                "search": "Pencarian",
                "lengthMenu": "Menampilkan _MENU_ data",
                "zeroRecords": "Maaf, Data tidak tersedia.",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                },
                "searchPlaceholder": "Masukan kata kunci"
            },
            scrollX: true
        };

        $(document).ready(function() {
            $("#tabel-data-klasifikasi").DataTable(dataTablesConfig);
        });
    </script>

    <script>
        Livewire.on('dataAdded', function(response) {
            dispatchSuccessDialog({
                title: "Berhasil!",
                text: response.message,
                confirmAction: {
                    type: 'redirect',
                    to: "{{ route('data-klasifikasi') }}",
                }
            });

            $("#dataKlasifikasiModal").modal('hide');
        });
    </script>
@endpush
