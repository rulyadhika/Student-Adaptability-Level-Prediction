<div>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="row">

        <!-- Area Chart -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row py-3 align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Training</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                        data-target="#importDataTrainingModal">Import Data</button>
                </div>
                <!-- Card Body -->
                <div class="card-body listMasukanCardBody">
                    <table id="masukanList" class="display table " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Subjek</th>
                                <th>Waktu Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
                    <h5 class="modal-title" id="importDataTrainingModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group @error('dataTrainingFile') is-invalid @enderror">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInputTrainingModal"
                                wire:model.defer="dataTrainingFile">
                            <label class="custom-file-label" for="fileInputTrainingModal"
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

</div>

@push('pageScript')
    <script type="application/javascript">
        $('#fileInputTrainingModal').change(function(e) {
            let fileName = e.target.files[0].name;
            $('.custom-file-label').text(fileName);
        });
    </script>
@endpush
