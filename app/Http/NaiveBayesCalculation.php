<?php

namespace App\Http;

use App\Models\DataTraining as ModelsDataTraining;

class NaiveBayesCalculation
{
    private $dataTesting;
    private $isTraining;

    public function __construct($dataTesting, $isTraining)
    {
        $this->dataTesting = $dataTesting;
        $this->isTraining = $isTraining;
    }

    public function calculate()
    {
        // $dataTraining = $this->dataTraining;
        $dataTesting = $this->dataTesting;

        // db data training
        $totalDataTraining = ModelsDataTraining::count();
        $jmlDataTrainingRendah = ModelsDataTraining::where('tingkat_adaptabilitas', 'Rendah')->count();
        $jmlDataTrainingSedang = ModelsDataTraining::where('tingkat_adaptabilitas', 'Sedang')->count();
        $jmlDataTrainingTinggi = ModelsDataTraining::where('tingkat_adaptabilitas', 'Tinggi')->count();
        $probDataTrainingRendah = $jmlDataTrainingRendah / $totalDataTraining;
        $probDataTrainingSedang = $jmlDataTrainingSedang / $totalDataTraining;
        $probDataTrainingTinggi = $jmlDataTrainingTinggi / $totalDataTraining;

        $calculatedTestingData = collect();

        //db data testing
        foreach ($dataTesting as $dataTest) {
            $jmlJenisKelaminRendah = ModelsDataTraining::where('jenis_kelamin', $dataTest->get('jenis_kelamin'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlJenisKelaminSedang = ModelsDataTraining::where('jenis_kelamin', $dataTest->get('jenis_kelamin'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlJenisKelaminTinggi = ModelsDataTraining::where('jenis_kelamin', $dataTest->get('jenis_kelamin'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probJenisKelaminRendah = $jmlJenisKelaminRendah / $jmlDataTrainingRendah;
            $probJenisKelaminSedang = $jmlJenisKelaminSedang / $jmlDataTrainingSedang;
            $probJenisKelaminTinggi = $jmlJenisKelaminTinggi / $jmlDataTrainingTinggi;

            $jmlUsiaRendah = ModelsDataTraining::where('usia', $dataTest->get('usia'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlUsiaSedang = ModelsDataTraining::where('usia', $dataTest->get('usia'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlUsiaTinggi = ModelsDataTraining::where('usia', $dataTest->get('usia'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probUsiaRendah = $jmlUsiaRendah / $jmlDataTrainingRendah;
            $probUsiaSedang = $jmlUsiaSedang / $jmlDataTrainingSedang;
            $probUsiaTinggi = $jmlUsiaTinggi / $jmlDataTrainingTinggi;

            $jmlPendidikanRendah = ModelsDataTraining::where('pendidikan', $dataTest->get('pendidikan'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlPendidikanSedang = ModelsDataTraining::where('pendidikan', $dataTest->get('pendidikan'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlPendidikanTinggi = ModelsDataTraining::where('pendidikan', $dataTest->get('pendidikan'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probPendidikanRendah = $jmlPendidikanRendah / $jmlDataTrainingRendah;
            $probPendidikanSedang = $jmlPendidikanSedang / $jmlDataTrainingSedang;
            $probPendidikanTinggi = $jmlPendidikanTinggi / $jmlDataTrainingTinggi;

            $jmlTipeInstitusiRendah = ModelsDataTraining::where('tipe_institusi', $dataTest->get('tipe_institusi'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlTipeInstitusiSedang = ModelsDataTraining::where('tipe_institusi', $dataTest->get('tipe_institusi'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlTipeInstitusiTinggi = ModelsDataTraining::where('tipe_institusi', $dataTest->get('tipe_institusi'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probTipeInstitusiRendah = $jmlTipeInstitusiRendah / $jmlDataTrainingRendah;
            $probTipeInstitusiSedang = $jmlTipeInstitusiSedang / $jmlDataTrainingSedang;
            $probTipeInstitusiTinggi = $jmlTipeInstitusiTinggi / $jmlDataTrainingTinggi;

            $jmlKeuanganRendah = ModelsDataTraining::where('keadaan_keuangan', $dataTest->get('keadaan_keuangan'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlKeuanganSedang = ModelsDataTraining::where('keadaan_keuangan', $dataTest->get('keadaan_keuangan'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlKeuanganTinggi = ModelsDataTraining::where('keadaan_keuangan', $dataTest->get('keadaan_keuangan'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probKeuanganRendah = $jmlKeuanganRendah / $jmlDataTrainingRendah;
            $probKeuanganSedang = $jmlKeuanganSedang / $jmlDataTrainingSedang;
            $probKeuanganTinggi = $jmlKeuanganTinggi / $jmlDataTrainingTinggi;

            $jmlTipeInternetRendah = ModelsDataTraining::where('tipe_internet', $dataTest->get('tipe_internet'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlTipeInternetSedang = ModelsDataTraining::where('tipe_internet', $dataTest->get('tipe_internet'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlTipeInternetTinggi = ModelsDataTraining::where('tipe_internet', $dataTest->get('tipe_internet'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probTipeInternetRendah = $jmlTipeInternetRendah / $jmlDataTrainingRendah;
            $probTipeInternetSedang = $jmlTipeInternetSedang / $jmlDataTrainingSedang;
            $probTipeInternetTinggi = $jmlTipeInternetTinggi / $jmlDataTrainingTinggi;

            $jmlTipeJaringanRendah = ModelsDataTraining::where('tipe_jaringan', $dataTest->get('tipe_jaringan'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlTipeJaringanSedang = ModelsDataTraining::where('tipe_jaringan', $dataTest->get('tipe_jaringan'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlTipeJaringanTinggi = ModelsDataTraining::where('tipe_jaringan', $dataTest->get('tipe_jaringan'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probTipeJaringanRendah = $jmlTipeJaringanRendah / $jmlDataTrainingRendah;
            $probTipeJaringanSedang = $jmlTipeJaringanSedang / $jmlDataTrainingSedang;
            $probTipeJaringanTinggi = $jmlTipeJaringanTinggi / $jmlDataTrainingTinggi;

            $jmlDurasiKelasRendah = ModelsDataTraining::where('durasi_kelas', $dataTest->get('durasi_kelas'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlDurasiKelasSedang = ModelsDataTraining::where('durasi_kelas', $dataTest->get('durasi_kelas'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlDurasiKelasTinggi = ModelsDataTraining::where('durasi_kelas', $dataTest->get('durasi_kelas'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
            $probDurasiKelasRendah = $jmlDurasiKelasRendah / $jmlDataTrainingRendah;
            $probDurasiKelasSedang = $jmlDurasiKelasSedang / $jmlDataTrainingSedang;
            $probDurasiKelasTinggi = $jmlDurasiKelasTinggi / $jmlDataTrainingTinggi;

            $jmlPerangkatRendah = ModelsDataTraining::where('perangkat', $dataTest->get('perangkat'))->where('tingkat_adaptabilitas', 'Rendah')->count();
            $jmlPerangkatSedang = ModelsDataTraining::where('perangkat', $dataTest->get('perangkat'))->where('tingkat_adaptabilitas', 'Sedang')->count();
            $jmlPerangkatTinggi = ModelsDataTraining::where('perangkat', $dataTest->get('perangkat'))->where('tingkat_adaptabilitas', 'Tinggi')->count();
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

            // urutin probabilitas terbesar
            $targetResult = $probabilityData->sortByDesc('val')->first()['name'];

            switch ($targetResult) {
                case 'probabilitasRendah':
                    $hasilPrediksi = 'Rendah';
                    break;

                case 'probabilitasSedang':
                    $hasilPrediksi = 'Sedang';
                    break;

                default:
                    $hasilPrediksi = 'Tinggi';
                    break;
            }

            $valid = null;
            if ($this->isTraining) {
                $valid = $dataTest->get('tingkat_adaptabilitas') == $hasilPrediksi ? 'Valid' : 'Tidak Valid';
            }

            $temp = $dataTest->merge([
                'hasil_prediksi' => $hasilPrediksi,
                'nilai_prob_rendah' => $probabilitasRendah,
                'nilai_prob_sedang' => $probabilitasSedang,
                'nilai_prob_tinggi' => $probabilitasTinggi,
                'prediksi_valid' => $valid
            ]);

            $calculatedTestingData->push($temp);
        }

        return $calculatedTestingData;
    }
}
