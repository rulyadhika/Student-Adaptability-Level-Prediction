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

    public function mount()
    {
        $this->title = 'Data Training';

        $this->dataTraining = ModelsDataTraining::all();
        $this->dataTesting = DataTesting::all();
    }

    public function render()
    {
        return view('livewire.naive-bayes.data-training');
    }

    public function saveDataTraining()
    {
        $this->validate([
            'dataTrainingFile' => 'required|mimes:csv'
        ]);

        Excel::import(new DataTrainingImport, $this->dataTrainingFile);

        $this->emit('importSuccessfull', ['message' => 'Data Training Berhasil Ditambahkan']);
    }

    public function saveDataTesting()
    {
        $this->validate([
            'dataTestingFile' => 'required|mimes:csv'
        ]);

        $this->dataTesting = collect(Excel::toArray(new DataTestingImport, $this->dataTestingFile)[0]);

        $this->calculateDataPrediction();

        $this->emit('importSuccessfull', ['message' => 'Data Testing Berhasil Ditambahkan']);
    }

    private function calculateDataPrediction()
    {
        $dataTraining = $this->dataTraining;
        $dataTesting = $this->dataTesting;

        // db data training
        $totalDataTraining = $dataTraining->count();
        $jmlDataTrainingRendah = $dataTraining->where('tingkat_adaptabilitas', 'Low')->count();
        $jmlDataTrainingSedang = $dataTraining->where('tingkat_adaptabilitas', 'Moderate')->count();
        $jmlDataTrainingTinggi = $dataTraining->where('tingkat_adaptabilitas', 'High')->count();
        $probDataTrainingRendah = $jmlDataTrainingRendah / $totalDataTraining;
        $probDataTrainingSedang = $jmlDataTrainingSedang / $totalDataTraining;
        $probDataTrainingTinggi = $jmlDataTrainingTinggi / $totalDataTraining;

        //db data testing
        foreach ($dataTesting as $dataTest) {
            dd($dataTest);
            $jmlJenisKelaminRendah = $dataTraining->where('jenis_kelamin', $dataTest->jenis_kelamin)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlJenisKelaminSedang = $dataTraining->where('jenis_kelamin', $dataTest->jenis_kelamin)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlJenisKelaminTinggi = $dataTraining->where('jenis_kelamin', $dataTest->jenis_kelamin)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probJenisKelaminRendah = $jmlJenisKelaminRendah / $jmlDataTrainingRendah;
            $probJenisKelaminSedang = $jmlJenisKelaminSedang / $jmlDataTrainingSedang;
            $probJenisKelaminTinggi = $jmlJenisKelaminTinggi / $jmlDataTrainingSedang;

            $jmlUsiaRendah = $dataTraining->where('usia', $dataTest->usia)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlUsiaSedang = $dataTraining->where('usia', $dataTest->usia)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlUsiaTinggi = $dataTraining->where('usia', $dataTest->usia)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probUsiaRendah = $jmlUsiaRendah / $jmlDataTrainingRendah;
            $probUsiaSedang = $jmlUsiaSedang / $jmlDataTrainingSedang;
            $probUsiaTinggi = $jmlUsiaTinggi / $jmlDataTrainingSedang;

            $jmlPendidikanRendah = $dataTraining->where('pendidikan', $dataTest->pendidikan)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlPendidikanSedang = $dataTraining->where('pendidikan', $dataTest->pendidikan)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlPendidikanTinggi = $dataTraining->where('pendidikan', $dataTest->pendidikan)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probPendidikanRendah = $jmlPendidikanRendah / $jmlDataTrainingRendah;
            $probPendidikanSedang = $jmlPendidikanSedang / $jmlDataTrainingSedang;
            $probPendidikanTinggi = $jmlPendidikanTinggi / $jmlDataTrainingSedang;

            $jmlTipeInstitusiRendah = $dataTraining->where('tipe_institusi', $dataTest->tipe_institusi)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlTipeInstitusiSedang = $dataTraining->where('tipe_institusi', $dataTest->tipe_institusi)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlTipeInstitusiTinggi = $dataTraining->where('tipe_institusi', $dataTest->tipe_institusi)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probTipeInstitusiRendah = $jmlTipeInstitusiRendah / $jmlDataTrainingRendah;
            $probTipeInstitusiSedang = $jmlTipeInstitusiSedang / $jmlDataTrainingSedang;
            $probTipeInstitusiTinggi = $jmlTipeInstitusiTinggi / $jmlDataTrainingSedang;

            $jmlKeuanganRendah = $dataTraining->where('keadaan_keuangan', $dataTest->keadaan_keuangan)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlKeuanganSedang = $dataTraining->where('keadaan_keuangan', $dataTest->keadaan_keuangan)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlKeuanganTinggi = $dataTraining->where('keadaan_keuangan', $dataTest->keadaan_keuangan)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probKeuanganRendah = $jmlKeuanganRendah / $jmlDataTrainingRendah;
            $probKeuanganSedang = $jmlKeuanganSedang / $jmlDataTrainingSedang;
            $probKeuanganTinggi = $jmlKeuanganTinggi / $jmlDataTrainingSedang;

            $jmlTipeInternetRendah = $dataTraining->where('tipe_internet', $dataTest->tipe_internet)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlTipeInternetSedang = $dataTraining->where('tipe_internet', $dataTest->tipe_internet)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlTipeInternetTinggi = $dataTraining->where('tipe_internet', $dataTest->tipe_internet)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probTipeInternetRendah = $jmlTipeInternetRendah / $jmlDataTrainingRendah;
            $probTipeInternetSedang = $jmlTipeInternetSedang / $jmlDataTrainingSedang;
            $probTipeInternetTinggi = $jmlTipeInternetTinggi / $jmlDataTrainingSedang;

            $jmlTipeJaringanRendah = $dataTraining->where('tipe_jaringan', $dataTest->tipe_jaringan)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlTipeJaringanSedang = $dataTraining->where('tipe_jaringan', $dataTest->tipe_jaringan)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlTipeJaringanTinggi = $dataTraining->where('tipe_jaringan', $dataTest->tipe_jaringan)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probTipeJaringanRendah = $jmlTipeJaringanRendah / $jmlDataTrainingRendah;
            $probTipeJaringanSedang = $jmlTipeJaringanSedang / $jmlDataTrainingSedang;
            $probTipeJaringanTinggi = $jmlTipeJaringanTinggi / $jmlDataTrainingSedang;

            $jmlDurasiKelasRendah = $dataTraining->where('durasi_kelas', $dataTest->durasi_kelas)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlDurasiKelasSedang = $dataTraining->where('durasi_kelas', $dataTest->durasi_kelas)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlDurasiKelasTinggi = $dataTraining->where('durasi_kelas', $dataTest->durasi_kelas)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probDurasiKelasRendah = $jmlDurasiKelasRendah / $jmlDataTrainingRendah;
            $probDurasiKelasSedang = $jmlDurasiKelasSedang / $jmlDataTrainingSedang;
            $probDurasiKelasTinggi = $jmlDurasiKelasTinggi / $jmlDataTrainingSedang;

            $jmlPerangkatRendah = $dataTraining->where('perangkat', $dataTest->perangkat)->where('tingkat_adaptabilitas', 'Low')->count();
            $jmlPerangkatSedang = $dataTraining->where('perangkat', $dataTest->perangkat)->where('tingkat_adaptabilitas', 'Moderate')->count();
            $jmlPerangkatTinggi = $dataTraining->where('perangkat', $dataTest->perangkat)->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probPerangkatRendah = $jmlPerangkatRendah / $jmlDataTrainingRendah;
            $probPerangkatSedang = $jmlPerangkatSedang / $jmlDataTrainingSedang;
            $probPerangkatTinggi = $jmlPerangkatTinggi / $jmlDataTrainingSedang;

            $probabilitasRendah = $probDataTrainingRendah * $probJenisKelaminRendah * $probUsiaRendah * $probPendidikanRendah
                * $probTipeInstitusiRendah * $probKeuanganRendah * $probTipeInternetRendah * $probTipeJaringanRendah
                * $probDurasiKelasRendah * $probPerangkatRendah;

            $probabilitasSedang = $probDataTrainingSedang * $probJenisKelaminSedang * $probUsiaSedang * $probPendidikanSedang
                * $probTipeInstitusiSedang * $probKeuanganSedang * $probTipeInternetSedang * $probTipeJaringanSedang
                * $probDurasiKelasSedang * $probPerangkatSedang;

            $probabilitasTinggi = $probDataTrainingTinggi * $probJenisKelaminTinggi * $probUsiaTinggi * $probPendidikanTinggi
                * $probTipeInstitusiTinggi * $probKeuanganTinggi * $probTipeInternetTinggi * $probTipeJaringanTinggi
                * $probDurasiKelasTinggi * $probPerangkatTinggi;

            if ($probabilitasRendah > $probabilitasSedang) {
                if ($probabilitasRendah < $probabilitasTinggi) {
                    $hasilPrediksi = 'High';
                } else {
                    $hasilPrediksi = 'Low';
                }

                $valid = $dataTest->tingkat_adaptabilitas == $hasilPrediksi ? 'Valid' : 'Tidak Valid';
            } else {
                if ($probabilitasSedang > $probabilitasTinggi) {
                    $hasilPrediksi = 'Moderate';
                } else {
                    $hasilPrediksi = 'High';
                }

                $valid = $dataTest->tingkat_adaptabilitas == $hasilPrediksi ? 'Valid' : 'Tidak Valid';
            }

            dd($hasilPrediksi, $valid);
        }
    }
}
