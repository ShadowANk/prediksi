<?php

namespace App\Http\Controllers;

class ModelEvaluationController extends Controller
{
    public function index()
    {
        $evaluation = $this->getModelEvaluation();

        return view(
            'evaluasi.index',
            compact('evaluation')
        );
    }

    private function getModelEvaluation(): array
    {
        $metadataPath = base_path(
            'ml-api' .
            DIRECTORY_SEPARATOR .
            'model_metadata.json'
        );

        $default = [
            'total_predicted' => 0,
            'accuracy' => 0,
            'balanced_accuracy' => 0,
            'precision' => 0,
            'recall' => 0,
            'f1_score' => 0,
            'train_accuracy' => 0,
            'train_test_gap' => 0,
            'tp' => 0,
            'tn' => 0,
            'fp' => 0,
            'fn' => 0,
        ];

        if (!file_exists($metadataPath)) {
            return $default;
        }

        $metadata = json_decode(
            file_get_contents($metadataPath),
            true
        );

        if (!is_array($metadata)) {
            return $default;
        }

        $hasil = $metadata['hasil_data_uji_persen'] ?? [];

        return [
            'total_predicted' => (
                ($hasil['tp'] ?? 0) +
                ($hasil['tn'] ?? 0) +
                ($hasil['fp'] ?? 0) +
                ($hasil['fn'] ?? 0)
            ),
            'accuracy' => $hasil['test_accuracy'] ?? 0,
            'balanced_accuracy' => $hasil['balanced_accuracy'] ?? 0,
            'precision' => $hasil['precision_terserap'] ?? 0,
            'recall' => $hasil['recall_terserap'] ?? 0,
            'f1_score' => $hasil['f1_terserap'] ?? 0,
            'train_accuracy' => $hasil['train_accuracy'] ?? 0,
            'train_test_gap' => $hasil['train_test_gap'] ?? 0,
            'tp' => $hasil['tp'] ?? 0,
            'tn' => $hasil['tn'] ?? 0,
            'fp' => $hasil['fp'] ?? 0,
            'fn' => $hasil['fn'] ?? 0,
        ];
    }
}
