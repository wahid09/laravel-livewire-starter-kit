<?php

namespace App\Http\Controllers\ImportData;

use App\Http\Controllers\Controller;
//use App\Models\$model;
use App\Jobs\DataImportInModel;
use App\Models\AccountUnit;
use App\Models\Pvms;
use Illuminate\Http\Request;

class ImportDataController extends Controller
{
    public function index()
    {
        $modelList = [];
        $path = app_path() . "/Models";
        $results = scandir($path);

        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $result;

            if (is_dir($filename)) {
                $modelList = array_merge($modelList, getModels($filename));
            } else {
                $modelList[] = substr($filename, 0, -4);
            }
        }
        return view('backend.importData.import_data', [
            'modelLists' => $modelList
        ]);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'file_import' => 'required|mimes:csv,txt',
            'model' => 'required',
        ]);
//        $model = 'App\\Models\\' . request()->model;
//        //dd($model);
//        $data = array_map('str_getcsv', file(request()->file_import));
//        $header = $data[0];
//        unset($data[0]);
//        foreach ($data as $item) {
//            $dataItem = array_combine($header, $item);
//            //dd($dataItem);
//            $model::create($dataItem);
//        }

        if (request()->has('file_import')) {
            $data = file(request()->file_import);
            // Chunking file
            $chunks = array_chunk($data, 1000);
            $header = [];
            //$batch = Bus::batch([])->dispatch();
            $model = request()->model;

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                //$batch->add(new SalesCsvProcess($data, $header));
                DataImportInModel::dispatch($data, $header, $model);
            }

            //return "Stored";
            return back()->with('success','Item Stored successfully!');
        }

        //return 'please upload file';
    }
}
