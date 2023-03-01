<?php

namespace App\Http\Livewire\Backend\ImportDataInModel;

use App\Jobs\DataImportInModel;
use App\Models\Pvms;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;


class ImportDataInModel extends Component
{
    use WithFileUploads;

    public $showEditModal = false;
    public $state = [];
    public $model = '';

    public function updated()
    {
        $this->state['model'] = $this->model;
    }

    public function uploadData()
    {
        if ($this->state['file_import']) {
            $model = $this->state['model'];
            $file = $this->state['file_import'];
            $tmpPath = $file->getRealPath();
            $data = str_getcsv(file_get_contents($tmpPath));
            $chunks = array_chunk($data, 1000);
            dd($chunks);
            $header = [];
            //$batch = Bus::batch([])->dispatch();
            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                foreach ($data as $item) {
                    $importData = array_combine($header, $item);
                    dd($importData);
                    Pvms::create($importData);
                }
                //$batch->add(new DataImportInModel($data, $header, $model));
            }
            //return $batch;
        }

    }

    public function render()
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
        //dd($modelList);
        return view('livewire.backend.import-data-in-model.import-data-in-model', [
            'modelLists' => $modelList
        ]);
    }

    public function batch()
    {
        //$batchId = request('id');
        //return Bus::findBatch($batchId);
    }

    public function batchInProgress()
    {
        $batches = DB::table('job_batches')->where('pending_jobs', '>', 0)->get();
        if (count($batches) > 0) {
            return Bus::findBatch($batches[0]->id);
        }

        return [];
    }
}
