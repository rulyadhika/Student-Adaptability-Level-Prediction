<?php

namespace App\Http\Livewire;

use App\Http\NaiveBayesCalculation;
use App\Models\DataClassification as ModelsDataClassification;
use App\Models\DataTraining;
use Livewire\Component;

class DataClassification extends Component
{
    public $title;

    public $nama;
    public $asal_sekolah;
    public $jenis_kelamin;
    public $usia;
    public $pendidikan;
    public $tipe_institusi;
    public $tipe_internet;
    public $tipe_jaringan;
    public $durasi_kelas;
    public $perangkat;
    public $keadaan_keuangan;

    public $dataKlasifikasi = [];

    protected $rules = [
        'nama' => 'required',
        'asal_sekolah' => 'required',
        'jenis_kelamin' => 'required',
        'usia' => 'required',
        'pendidikan' => 'required',
        'tipe_institusi' => 'required',
        'tipe_internet' => 'required',
        'tipe_jaringan' => 'required',
        'durasi_kelas' => 'required',
        'perangkat' => 'required',
        'keadaan_keuangan' => 'required',
    ];

    public function mount(){
        $this->title = 'Klasifikasi Data';

        $this->dataKlasifikasi = ModelsDataClassification::all();
    }

    public function render()
    {
        return view('livewire.data-classification');
    }

    public function save(){
        $validatedData = $this->validate();

        if(DataTraining::count() == 0){
            return $this->emit('failedAction', ['message' => 'Silahkan tambahkan data training terlebih dahulu!']);
        }

        $naiveBayes = new NaiveBayesCalculation(array(collect($validatedData)), false);
        $calculatedClassificationData = $naiveBayes->calculate();

        ModelsDataClassification::create($calculatedClassificationData->toArray()[0]);

        $this->emit('dataAdded', ['message' => 'Data Berhasil Ditambahkan']);
    }
}
