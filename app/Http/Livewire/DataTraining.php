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

        if($totalDataTesting > 0){
            $lowLow = $dataTesting->where('tingkat_adaptabilitas', 'Low')->where('hasil_prediksi', 'Low')->count();
            $lowMod = $dataTesting->where('tingkat_adaptabilitas', 'Low')->where('hasil_prediksi', 'Moderate')->count();
            $lowHigh = $dataTesting->where('tingkat_adaptabilitas', 'Low')->where('hasil_prediksi', 'High')->count();

            $modLow = $dataTesting->where('tingkat_adaptabilitas', 'Moderate')->where('hasil_prediksi', 'Low')->count();
            $modMod = $dataTesting->where('tingkat_adaptabilitas', 'Moderate')->where('hasil_prediksi', 'Moderate')->count();
            $modHigh = $dataTesting->where('tingkat_adaptabilitas', 'Moderate')->where('hasil_prediksi', 'High')->count();

            $highLow = $dataTesting->where('tingkat_adaptabilitas', 'High')->where('hasil_prediksi', 'Low')->count();
            $highMod = $dataTesting->where('tingkat_adaptabilitas', 'High')->where('hasil_prediksi', 'Moderate')->count();
            $highHigh = $dataTesting->where('tingkat_adaptabilitas', 'High')->where('hasil_prediksi', 'High')->count();

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
            'dataTrainingFile' => 'required|mimes:csv'
        ]);

        Excel::import(new DataTrainingImport, $this->dataTrainingFile);

        $this->dataTraining = collect();

        $this->emit('importSuccessfull', ['message' => 'Data Training Berhasil Ditambahkan']);
    }

    public function saveDataTesting()
    {
        $this->validate([
            'dataTestingFile' => 'required|mimes:csv'
        ]);

        $importDataTesting = Excel::toCollection(new DataTestingImport, $this->dataTestingFile)[0];
        $tempDataTesting = collect();

        foreach ($importDataTesting as $data) {
            $tempDataTesting->push(collect([
                'jenis_kelamin' => $data[0],
                'usia' => $data[1],
                'pendidikan' => $data[2],
                'tipe_institusi' => $data[3],
                'keadaan_keuangan' => $data[7],
                'tipe_internet' => $data[8],
                'tipe_jaringan' => $data[9],
                'durasi_kelas' => $data[10],
                'perangkat' => $data[12],
                'tingkat_adaptabilitas' => $data[13]
            ]));
        }

        $this->dataTesting = $tempDataTesting;

        $this->calculateDataPrediction();

        $this->emit('importSuccessfull', ['message' => 'Data Testing Berhasil Ditambahkan']);
    }

    private function calculateDataPrediction()
    {
        $naiveBayes = new NaiveBayesCalculation($this->dataTesting, true);
        $calculatedTestingData = $naiveBayes->calculate();

        DataTesting::insert($calculatedTestingData->toArray());

        $this->dataTesting = collect();
    }
}
