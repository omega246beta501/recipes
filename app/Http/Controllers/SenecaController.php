<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SenecaController extends Controller
{
    public function index()
    {
        return Inertia::render('SenecaComparerPage');
    }

    public function compareIdoceoSeneca(Request $request) {
        $data = RequestHelper::requestToArray($request);

        return $this->compareBothFiles($data);
    }

    public function compareBothFiles($data) {
        $mainFile = $data['secondCsv'];
        $fileToCompare = $data['firstCsv'];

        if(count($mainFile) != count($fileToCompare)) {
            return response()->json(['error' => 'Files must have the same number of rows'], 400);
        }

        $mainFileFields = array_keys($mainFile[0]);
        $studentNameField = $mainFileFields[0];

        $mainFile = $this->sanitizeFields($mainFile);
        $fileToCompare = $this->sanitizeFields($fileToCompare);

        $mainFileFields = array_slice($mainFileFields, 1);

        $comparisonData = [];

        for ($i = 0; $i < count($mainFile); $i++) {
            $mainFileRow = $mainFile[$i];
            $fileToCompareRow = $fileToCompare[$i];

            // $comparisonData[$mainFileRow[$studentNameField]] = [];

            foreach($mainFileFields as $field) {
                $mainFileValue = $this->sanitizeValue($mainFileRow[$field]);
                $fileToCompareValue = $this->sanitizeValue($fileToCompareRow[$field]);

                $areEqual = $mainFileValue == $fileToCompareValue;

                if (!$areEqual) {
                    $comparisonData[$mainFileRow[$studentNameField]][$field] = [
                        'mainFile' => $mainFileValue,
                        'fileToCompare' => $fileToCompareValue,
                        'areEqual' => $areEqual,
                        'difference' => $mainFileValue - $fileToCompareValue,
                    ];
                }
            }
        }

        Log::info(json_encode($comparisonData));

        return $comparisonData;
    }

    public function sanitizeValue($value) {
        if(is_string($value) && strpos($value, '/') !== false) {
            return explode('/', $value)[0];
        }
        return $value;
    }

    public function sanitizeFields($data) {
        foreach($data as &$row) {
            foreach($row as $key => $value) {
                unset($row[$key]);
                $sanitizedKey = trim(str_replace('.', ' ', $key));
                $row[$sanitizedKey] = $value;
            }
        }
        return $data;
    }
}
