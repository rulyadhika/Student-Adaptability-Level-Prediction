<?php

namespace App\Http\Livewire;

use App\Http\NaiveBayesCalculation;
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

    public $addToDataTraining;
    public $deleteDataTraining;

    public $accuracy = 0;
    public $precission = 0;
    public $recall = 0;

    public function mount()
    {
        $this->title = 'Data Training';

        $this->dataTraining = ModelsDataTraining::all();
        $dataTesting = DataTesting::all();
        $this->dataTesting = $dataTesting;

        $totalDataTesting = $this->dataTesting->count();

        if ($totalDataTesting > 0) {
            $lowLow = $dataTesting->where('tingkat_adaptabilitas', 'Rendah')->where('hasil_prediksi', 'Rendah')->count();
            $lowMod = $dataTesting->where('tingkat_adaptabilitas', 'Rendah')->where('hasil_prediksi', 'Sedang')->count();
            $lowHigh = $dataTesting->where('tingkat_adaptabilitas', 'Rendah')->where('hasil_prediksi', 'Tinggi')->count();

            $modLow = $dataTesting->where('tingkat_adaptabilitas', 'Sedang')->where('hasil_prediksi', 'Rendah')->count();
            $modMod = $dataTesting->where('tingkat_adaptabilitas', 'Sedang')->where('hasil_prediksi', 'Sedang')->count();
            $modHigh = $dataTesting->where('tingkat_adaptabilitas', 'Sedang')->where('hasil_prediksi', 'Tinggi')->count();

            $highLow = $dataTesting->where('tingkat_adaptabilitas', 'Tinggi')->where('hasil_prediksi', 'Rendah')->count();
            $highMod = $dataTesting->where('tingkat_adaptabilitas', 'Tinggi')->where('hasil_prediksi', 'Sedang')->count();
            $highHigh = $dataTesting->where('tingkat_adaptabilitas', 'Tinggi')->where('hasil_prediksi', 'Tinggi')->count();

            /*
                                prediction
                | fact       low moderate hight   |
                | low                           |
                | moderate                      |
                | high                          |
            */

            $confusionMatrix =
                [
                    [$lowLow, $lowMod, $lowHigh],
                    [$modLow, $modMod, $modHigh],
                    [$highLow, $highMod, $highHigh]
                ];

            // calculate accuracy
            $accuracy = round(($lowLow + $modMod + $highHigh) / $totalDataTesting * 100, 2);

            // calculate precission
            // $precission = round( ($lowLow / ($lowLow + $lowMod + $lowHigh) + ($modMod / ($modLow + $modMod + $modHigh) + ($highHigh / ($highLow + $highMod + $highHigh) ) ) ) / 3 * 100,2);

            $precission = 0;
            foreach ($confusionMatrix as $index => $matrix) {
                $precission += $matrix[$index] / array_sum($confusionMatrix[$index]);
            }

            $precission = round($precission / 3 * 100, 2);

            // calculate recall
            // $recall = round( ($lowLow / ($lowLow + $modLow + $highLow) + ($modMod / ($lowMod + $modMod + $highMod) + ($highHigh / ($lowHigh + $modHigh + $highHigh) ) ) ) / 3 * 100,2);

            $recall = 0;
            foreach ($confusionMatrix as $index => $matrix) {
                $tempRecall = 0;

                for ($j = 0; $j < 3; $j++) {
                    $tempRecall += $confusionMatrix[$j][$index];
                }

                $recall += $matrix[$index] / $tempRecall;
            }

            $recall = round($recall / 3 * 100, 2);

            $this->fill([
                'accuracy' => $accuracy,
                'precission' => $precission,
                'recall' => $recall
            ]);
        }
    }

    public function render()
    {
        return view('livewire.data-training');
    }

    public function saveDataTraining()
    {
        $this->validate([
            'dataTrainingFile' => 'required|file'
        ]);

        if ($this->deleteDataTraining) {
            ModelsDataTraining::truncate();
            DataTesting::truncate();
        }

        Excel::import(new DataTrainingImport, $this->dataTrainingFile);

        $this->dataTraining = collect();

        $this->emit('importSuccessfull', ['message' => 'Data Training Berhasil Ditambahkan']);
    }

    public function saveDataTesting()
    {
        $this->validate([
            'dataTestingFile' => 'required|file'
        ]);

        if (ModelsDataTraining::count() == 0) {
            return $this->emit('failedAction', ['message' => 'Silahkan tambahkan data training terlebih dahulu!']);
        }

        $importDataTesting = Excel::toCollection(new DataTestingImport, $this->dataTestingFile)[0];

        $this->dataTesting = $importDataTesting;

        $this->calculateDataPrediction();

        $this->emit('importSuccessfull', ['message' => 'Data Testing Berhasil Ditambahkan']);
    }

    private function calculateDataPrediction()
    {
        $naiveBayes = new NaiveBayesCalculation($this->dataTesting, true);
        $calculatedTestingData = $naiveBayes->calculate();

        DataTesting::truncate();
        DataTesting::insert($calculatedTestingData->toArray());

        if ($this->addToDataTraining) {
            ModelsDataTraining::insert($this->dataTesting->toArray());
        }

        $this->dataTesting = collect();
    }
}
