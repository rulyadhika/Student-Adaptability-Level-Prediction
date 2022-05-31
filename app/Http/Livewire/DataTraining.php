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
        // $dataTraining = $this->dataTraining;
        $dataTesting = $this->dataTesting;

        // db data training
        $totalDataTraining = ModelsDataTraining::count();
        $jmlDataTrainingRendah = ModelsDataTraining::where('tingkat_adaptabilitas', 'Low')->count();
        $jmlDataTrainingSedang = ModelsDataTraining::where('tingkat_adaptabilitas', 'Moderate')->count();
        $jmlDataTrainingTinggi = ModelsDataTraining::where('tingkat_adaptabilitas', 'High')->count();
        $probDataTrainingRendah = $jmlDataTrainingRendah / $totalDataTraining;
        $probDataTrainingSedang = $jmlDataTrainingSedang / $totalDataTraining;
        $probDataTrainingTinggi = $jmlDataTrainingTinggi / $totalDataTraining;

        $calculatedTestingData = collect();

        //db data testing
        foreach ($dataTesting as $dataTest) {
            $jmlJenisKelaminRendah = ModelsDataTraining::where('jenis_kelamin', $dataTest->get('jenis_kelamin'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlJenisKelaminSedang = ModelsDataTraining::where('jenis_kelamin', $dataTest->get('jenis_kelamin'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlJenisKelaminTinggi = ModelsDataTraining::where('jenis_kelamin', $dataTest->get('jenis_kelamin'))->where('tingkat_adaptabilitas', 'High')->count();
            $probJenisKelaminRendah = $jmlJenisKelaminRendah / $jmlDataTrainingRendah;
            $probJenisKelaminSedang = $jmlJenisKelaminSedang / $jmlDataTrainingSedang;
            $probJenisKelaminTinggi = $jmlJenisKelaminTinggi / $jmlDataTrainingTinggi;

            $jmlUsiaRendah = ModelsDataTraining::where('usia', $dataTest->get('usia'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlUsiaSedang = ModelsDataTraining::where('usia', $dataTest->get('usia'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlUsiaTinggi = ModelsDataTraining::where('usia', $dataTest->get('usia'))->where('tingkat_adaptabilitas', 'High')->count();
            $probUsiaRendah = $jmlUsiaRendah / $jmlDataTrainingRendah;
            $probUsiaSedang = $jmlUsiaSedang / $jmlDataTrainingSedang;
            $probUsiaTinggi = $jmlUsiaTinggi / $jmlDataTrainingTinggi;

            $jmlPendidikanRendah = ModelsDataTraining::where('pendidikan', $dataTest->get('pendidikan'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlPendidikanSedang = ModelsDataTraining::where('pendidikan', $dataTest->get('pendidikan'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlPendidikanTinggi = ModelsDataTraining::where('pendidikan', $dataTest->get('pendidikan'))->where('tingkat_adaptabilitas', 'High')->count();
            $probPendidikanRendah = $jmlPendidikanRendah / $jmlDataTrainingRendah;
            $probPendidikanSedang = $jmlPendidikanSedang / $jmlDataTrainingSedang;
            $probPendidikanTinggi = $jmlPendidikanTinggi / $jmlDataTrainingTinggi;

            $jmlTipeInstitusiRendah = ModelsDataTraining::where('tipe_institusi', $dataTest->get('tipe_institusi'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlTipeInstitusiSedang = ModelsDataTraining::where('tipe_institusi', $dataTest->get('tipe_institusi'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlTipeInstitusiTinggi = ModelsDataTraining::where('tipe_institusi', $dataTest->get('tipe_institusi'))->where('tingkat_adaptabilitas', 'High')->count();
            $probTipeInstitusiRendah = $jmlTipeInstitusiRendah / $jmlDataTrainingRendah;
            $probTipeInstitusiSedang = $jmlTipeInstitusiSedang / $jmlDataTrainingSedang;
            $probTipeInstitusiTinggi = $jmlTipeInstitusiTinggi / $jmlDataTrainingTinggi;

            $jmlKeuanganRendah = ModelsDataTraining::where('keadaan_keuangan', $dataTest->get('keadaan_keuangan'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlKeuanganSedang = ModelsDataTraining::where('keadaan_keuangan', $dataTest->get('keadaan_keuangan'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlKeuanganTinggi = ModelsDataTraining::where('keadaan_keuangan', $dataTest->get('keadaan_keuangan'))->where('tingkat_adaptabilitas', 'High')->count();
            $probKeuanganRendah = $jmlKeuanganRendah / $jmlDataTrainingRendah;
            $probKeuanganSedang = $jmlKeuanganSedang / $jmlDataTrainingSedang;
            $probKeuanganTinggi = $jmlKeuanganTinggi / $jmlDataTrainingTinggi;

            $jmlTipeInternetRendah = ModelsDataTraining::where('tipe_internet', $dataTest->get('tipe_internet'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlTipeInternetSedang = ModelsDataTraining::where('tipe_internet', $dataTest->get('tipe_internet'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlTipeInternetTinggi = ModelsDataTraining::where('tipe_internet', $dataTest->get('tipe_internet'))->where('tingkat_adaptabilitas', 'High')->count();
            $probTipeInternetRendah = $jmlTipeInternetRendah / $jmlDataTrainingRendah;
            $probTipeInternetSedang = $jmlTipeInternetSedang / $jmlDataTrainingSedang;
            $probTipeInternetTinggi = $jmlTipeInternetTinggi / $jmlDataTrainingTinggi;

            $jmlTipeJaringanRendah = ModelsDataTraining::where('tipe_jaringan', $dataTest->get('tipe_jaringan'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlTipeJaringanSedang = ModelsDataTraining::where('tipe_jaringan', $dataTest->get('tipe_jaringan'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlTipeJaringanTinggi = ModelsDataTraining::where('tipe_jaringan', $dataTest->get('tipe_jaringan'))->where('tingkat_adaptabilitas', 'High')->count();
            $probTipeJaringanRendah = $jmlTipeJaringanRendah / $jmlDataTrainingRendah;
            $probTipeJaringanSedang = $jmlTipeJaringanSedang / $jmlDataTrainingSedang;
            $probTipeJaringanTinggi = $jmlTipeJaringanTinggi / $jmlDataTrainingTinggi;

            $jmlDurasiKelasRendah = ModelsDataTraining::where('durasi_kelas', $dataTest->get('durasi_kelas'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlDurasiKelasSedang = ModelsDataTraining::where('durasi_kelas', $dataTest->get('durasi_kelas'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlDurasiKelasTinggi = ModelsDataTraining::where('durasi_kelas', $dataTest->get('durasi_kelas'))->where('tingkat_adaptabilitas', 'High')->count();
            $probDurasiKelasRendah = $jmlDurasiKelasRendah / $jmlDataTrainingRendah;
            $probDurasiKelasSedang = $jmlDurasiKelasSedang / $jmlDataTrainingSedang;
            $probDurasiKelasTinggi = $jmlDurasiKelasTinggi / $jmlDataTrainingTinggi;

            $jmlPerangkatRendah = ModelsDataTraining::where('perangkat', $dataTest->get('perangkat'))->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlPerangkatSedang = ModelsDataTraining::where('perangkat', $dataTest->get('perangkat'))->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlPerangkatTinggi = ModelsDataTraining::where('perangkat', $dataTest->get('perangkat'))->where('tingkat_adaptabilitas', 'High')->count();
            $probPerangkatRendah = $jmlPerangkatRendah / $jmlDataTrainingRendah;
            $probPerangkatSedang = $jmlPerangkatSedang / $jmlDataTrainingSedang;
            $probPerangkatTinggi = $jmlPerangkatTinggi / $jmlDataTrainingTinggi;

            $probabilitasRendah = $probDataTrainingRendah * $probJenisKelaminRendah * $probUsiaRendah * $probPendidikanRendah
                * $probTipeInstitusiRendah * $probKeuanganRendah * $probTipeInternetRendah * $probTipeJaringanRendah
                * $probDurasiKelasRendah * $probPerangkatRendah;

            $probabilitasSedang = $probDataTrainingSedang * $probJenisKelaminSedang * $probUsiaSedang * $probPendidikanSedang
                * $probTipeInstitusiSedang * $probKeuanganSedang * $probTipeInternetSedang * $probTipeJaringanSedang
                * $probDurasiKelasSedang * $probPerangkatSedang;

            $probabilitasTinggi = $probDataTrainingTinggi * $probJenisKelaminTinggi * $probUsiaTinggi * $probPendidikanTinggi
                * $probTipeInstitusiTinggi * $probKeuanganTinggi * $probTipeInternetTinggi * $probTipeJaringanTinggi
                * $probDurasiKelasTinggi * $probPerangkatTinggi;

            $probabilityData = collect([
                [
                    'name' => 'probabilitasRendah',
                    'val' => $probabilitasRendah
                ],
                [
                    'name' => 'probabilitasSedang',
                    'val' => $probabilitasSedang
                ],
                [
                    'name' => 'probabilitasTinggi',
                    'val' => $probabilitasTinggi
                ],
            ]);

            $targetResult = $probabilityData->sortByDesc('val')->first()['name'];

            switch ($targetResult) {
                case 'probabilitasRendah':
                    $hasilPrediksi = 'Low';
                    break;

                case 'probabilitasSedang':
                    $hasilPrediksi = 'Moderate';
                    break;

                default:
                    $hasilPrediksi = 'High';
                    break;
            }

            $valid = $dataTest->get('tingkat_adaptabilitas') == $hasilPrediksi ? 'Valid' : 'Tidak Valid';

            $temp = $dataTest->merge([
                'hasil_prediksi' => $hasilPrediksi,
                'nilai_prob_rendah' => $probabilitasRendah,
                'nilai_prob_sedang' => $probabilitasSedang,
                'nilai_prob_tinggi' => $probabilitasTinggi,
                'prediksi_valid' => $valid
            ]);

            $calculatedTestingData->push($temp);
        }

        DataTesting::insert($calculatedTestingData->toArray());

        $this->dataTesting = collect();
    }
}
