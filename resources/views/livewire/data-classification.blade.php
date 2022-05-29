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
                                <th>Umur</th>
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
                                    <td>{{ $data->umur }}</td>
                                    <td>{{ $data->pendidikan }}</td>
                                    <td>{{ $data->tipe_institusi }}</td>
                                    <td>{{ $data->keadaan_keuangan }}</td>
                                    <td>{{ $data->tipe_internet }}</td>
                                    <td>{{ $data->tipe_jaringan }}</td>
                                    <td>{{ $data->durasi_kelas }}</td>
                                    <td>{{ $data->perangkat }}</td>
                                    <td>{{ $data->nilai_prob_rendah }}</td>
                                    <td>{{ $data->nilai_prob_sedang }}</td>
                                    <td>{{ $data->nilai_prob_tinggi }}</td>
                                    <td>{{ $data->tingkat_adaptabilitas }}</td>
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
                            <input type="text" class="form-control" id="nama" wire:model.defer="nama">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="asalSekolah">Asal Sekolah</label>
                            <input type="text" class="form-control" id="asalSekolah" wire:model.defer="asalSekolah">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jenisKelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenisKelamin" wire:model.defer="jenisKelamin">
                                <option>-- Pilih Jenis Kelamin --</option>
                                <option value="Boy">Laki - laki</option>
                                <option value="Girl">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="umur">Umur</label>
                            <select class="form-control" id="umur" wire:model.defer="umur">
                                <option>-- Pilih Umur --</option>
                                <option value="1-5">1 Tahun - 5 Tahun</option>
                                <option value="6-10">6 Tahun - 10 Tahun</option>
                                <option value="11-15">11 Tahun - 15 Tahun</option>
                                <option value="16-20">16 Tahun - 20 Tahun</option>
                                <option value="21-25">21 Tahun - 25 Tahun</option>
                                <option value="26-30">26 Tahun - 30 Tahun</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pendidikan">Pendidikan</label>
                            <select class="form-control" id="pendidikan" wire:model.defer="pendidikan">
                                <option>-- Pilih Pendidikan --</option>
                                <option value="School">Sekolah (SD,SMP,SMA)</option>
                                <option value="University">Universitas</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipeInsitusi">Tipe Insitusi</label>
                            <select class="form-control" id="tipeInsitusi" wire:model.defer="tipeInsitusi">
                                <option>-- Pilih Tipe Insitusi --</option>
                                <option value="Government">Pemerintah</option>
                                <option value="Non Government">Non Pemerintah</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tipeInternet">Tipe Internet</label>
                            <select class="form-control" id="tipeInternet" wire:model.defer="tipeInternet">
                                <option>-- Pilih Tipe Internet --</option>
                                <option value="Wifi">Wifi</option>
                                <option value="Mobile Data">Paket Data</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipeJaringan">Tipe Jaringan</label>
                            <select class="form-control" id="tipeJaringan" wire:model.defer="tipeJaringan">
                                <option>-- Pilih Tipe Jaringan --</option>
                                <option value="4G">4G</option>
                                <option value="3G">3G</option>
                                <option value="2G">2G</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="durasiKelas">Durasi Kelas</label>
                            <select class="form-control" id="durasiKelas" wire:model.defer="durasiKelas">
                                <option>-- Pilih Durasi Kelas --</option>
                                <option value="1-3">1-3 Jam</option>
                                <option value="3-6">3-6 Jam</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="perangkat">Perangkat</label>
                            <select class="form-control" id="perangkat" wire:model.defer="perangkat">
                                <option>-- Pilih Perangkat --</option>
                                <option value="Mobile">Smartphone</option>
                                <option value="Tab">Tablet</option>
                                <option value="Computer">Laptop/Komputer</option>
                            </select>
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="keadaanKeuangan">Keadaan Keuangan</label>
                        <select class="form-control" id="keadaanKeuangan" wire:model.defer="keadaanKeuangan">
                            <option>-- Pilih Keadaan Keuangan --</option>
                            <option value="Poor">Mengenah Kebawah</option>
                            <option value="Mid">Menengah Keatas</option>
                            <option value="Rich">Mampu</option>
                        </select>
                    </div>

                    {{-- @error('dataTestingFile') is-invalid @enderror
                    @error('dataTestingFile')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="">Tambah Data</button>
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
        Livewire.on('importSuccessfull', function(response) {
            dispatchSuccessDialog({
                title: "Berhasil!",
                text: response.message,
                confirmAction: {
                    type: 'redirect',
                    to: "{{ route('data-klasifikasi') }}",
                }
            });

            $("#importDataTrainingModal").modal('hide');
        });
    </script>
@endpush
