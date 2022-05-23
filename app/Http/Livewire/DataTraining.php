<?php

namespace App\Http\Livewire;

use App\Imports\DataTestingImport;
use App\Imports\DataTrainingImport;
use App\Models\DataTesting;
use App\Models\DataTraining as ModelsDataTraining;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DataTraining extends Component
{
    use WithFileUploads;

    public $title;
    public $dataTraining;
    public $dataTesting;

    public $dataTrainingFile;
    public $dataTestingFile;

    public function mount(){
        $this->title = 'Data Training';

        $this->dataTraining = ModelsDataTraining::all();
        $this->dataTesting = DataTesting::all();
    }

    public function render()
    {
        return view('livewire.naive-bayes.data-training');
    }

    public function saveDataTraining(){
        $this->validate([
            'dataTrainingFile' => 'required|mimes:csv'
        ]);

        Excel::import(new DataTrainingImport, $this->dataTrainingFile);

        $this->emit('importSuccessfull',['message' => 'Data Training Berhasil Ditambahkan']);
    }

    public function saveDataTesting(){
        $this->validate([
            'dataTestingFile' => 'required|mimes:csv'
        ]);

        Excel::import(new DataTestingImport, $this->dataTestingFile);

        $this->emit('importSuccessfull',['message' => 'Data Testing Berhasil Ditambahkan']);
    }
}
