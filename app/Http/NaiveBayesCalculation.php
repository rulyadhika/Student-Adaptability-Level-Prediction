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

            // urutin probabilitas terbesar
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
