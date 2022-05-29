<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DataClassification extends Component
{
    public $title;
    public $dataKlasifikasi = [];

    public function mount(){
        $this->title = 'Klasifikasi Data';

    }

    public function render()
    {
        return view('livewire.data-classification');
    }
}
