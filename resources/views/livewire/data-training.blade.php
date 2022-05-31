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
                    <h6 class="m-0 font-weight-bold text-primary">Data Training</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                        data-target="#importDataTrainingModal">Import Data</button>
                </div>
                <!-- Card Body -->
                <div class="card-body listMasukanCardBody" wire:ignore>
                    <table id="tabel-data-training" class="display table " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th style="min-width:unset;">No</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Pendidikan</th>
                                <th>Tipe Institusi</th>
                                <th style="min-width:120px;">Keuangan</th>
                                <th>Tipe Internet</th>
                                <th>Tipe Jaringan</th>
                                <th>Durasi Kelas</th>
                                <th>Perangkat</th>
                                <th style="min-width:170px;">Tingkat Adaptabilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTraining as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->jenis_kelamin }}</td>
                                    <td>{{ $data->usia }}</td>
                                    <td>{{ $data->pendidikan }}</td>
                                    <td>{{ $data->tipe_institusi }}</td>
                                    <td>{{ $data->keadaan_keuangan }}</td>
                                    <td>{{ $data->tipe_internet }}</td>
                                    <td>{{ $data->tipe_jaringan }}</td>
                                    <td>{{ $data->durasi_kelas }}</td>
                                    <td>{{ $data->perangkat }}</td>
                                    <td>{{ $data->tingkat_adaptabilitas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row py-3 align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Testing</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                        data-target="#importDataTestingModal">Import Data</button>
                </div>
                <!-- Card Body -->
                <div class="card-body listMasukanCardBody" wire:ignore>
                    <table id="tabel-data-testing" class="display table " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th style="min-width:unset;">No</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Pendidikan</th>
                                <th>Tipe Institusi</th>
                                <th style="min-width:120px;">Keuangan</th>
                                <th>Tipe Internet</th>
                                <th>Tipe Jaringan</th>
                                <th>Durasi Kelas</th>
                                <th>Perangkat</th>
                                <th style="min-width:170px;">Tingkat Adaptabilitas</th>
                                <th>Nilai Prob Rendah</th>
                                <th>Nilai Prob Sedang</th>
                                <th>Nilai Prob Tinggi</th>
                                <th>Hasil Prediksi</th>
                                <th>Valid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTesting as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->jenis_kelamin }}</td>
                                    <td>{{ $data->usia }}</td>
                                    <td>{{ $data->pendidikan }}</td>
                                    <td>{{ $data->tipe_institusi }}</td>
                                    <td>{{ $data->keadaan_keuangan }}</td>
                                    <td>{{ $data->tipe_internet }}</td>
                                    <td>{{ $data->tipe_jaringan }}</td>
                                    <td>{{ $data->durasi_kelas }}</td>
                                    <td>{{ $data->perangkat }}</td>
                                    <td>{{ $data->tingkat_adaptabilitas }}</td>
                                    <td style="min-width:200px;">{{ $data->nilai_prob_rendah }}</td>
                                    <td style="min-width:200px;">{{ $data->nilai_prob_sedang }}</td>
                                    <td style="min-width:200px;">{{ $data->nilai_prob_tinggi }}</td>
                                    <td>{{ $data->hasil_prediksi }}</td>
                                    <td>{{ $data->prediksi_valid }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hasil</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row font-weight-bold text-center">
                        <div class="col-md-4">
                            Accuracy : {{ $accuracy }} %
                        </div>
                        <div class="col-md-4">
                            Precission : {{ $precission }} %
                        </div>
                        <div class="col-md-4">
                            Recall : {{ $recall }} %
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importDataTrainingModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="importDataTrainingModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importDataTrainingModalLabel">Import Data Training</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group @error('dataTrainingFile') is-invalid @enderror">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInputTrainingModal"
                                wire:model.defer="dataTrainingFile">
                            <label class="custom-file-label label-file-training-input" for="fileInputTrainingModal"
                                aria-describedby="inputGroupFileAddon01" wire:ignore>Choose file</label>
                        </div>
                    </div>
                    <small>*Ukuran file maksimal 1MB. Ekstensi yang diperbolehkan csv. </small>
                    @error('dataTrainingFile')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="saveDataTraining">Import</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importDataTestingModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="importDataTestingModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importDataTestingModalLabel">Import Data Testing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group @error('dataTestingFile') is-invalid @enderror">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInputTestingModal"
                                wire:model.defer="dataTestingFile">
                            <label class="custom-file-label label-file-testing-input" for="fileInputTestingModal"
                                aria-describedby="inputGroupFileAddon01" wire:ignore>Choose file</label>
                        </div>
                    </div>
                    <small>*Ukuran file maksimal 1MB. Ekstensi yang diperbolehkan csv. </small>
                    @error('dataTestingFile')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="saveDataTesting">Import</button>
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
            $("#tabel-data-training").DataTable(dataTablesConfig);
            $("#tabel-data-testing").DataTable(dataTablesConfig);
        });
    </script>

    <script type="application/javascript">
        $('#fileInputTrainingModal').change(function(e) {
            let fileName = e.target.files[0].name;
            $('.label-file-training-input').text(fileName);
        });

        $('#fileInputTestingModal').change(function(e) {
            let fileName = e.target.files[0].name;
            $('.label-file-testing-input').text(fileName);
        });
    </script>

    <script>
        Livewire.on('importSuccessfull', function(response) {
            dispatchSuccessDialog({
                title: "Berhasil!",
                text: response.message,
                confirmAction : {
                    type : 'redirect',
                    to : "{{ route('data-training') }}",
                }
            });

            $("#importDataTrainingModal").modal('hide');
            $("#importDataTestingModal").modal('hide');
        });
    </script>
@endpush
