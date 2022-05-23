<?php

namespace App\Http\Livewire\NaiveBayes;

use Livewire\Component;
use Livewire\WithFileUploads;

class DataTraining extends Component
{
    use WithFileUploads;

    public $title;
    public $dataTrainingFile;

    public function mount(){
        $this->title = 'Data Training';
    }

    public function render()
    {
        return view('livewire.naive-bayes.data-training');
    }

    public function saveDataTraining(){
        $this->validate([
            'dataTrainingFile' => 'file|max:1024|mimes:csv'
        ]);
    }
}
