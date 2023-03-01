<?php

namespace App\Jobs;

use App\Models\AccountUnit;
use App\Models\Pvms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class DataImportInModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;
    public $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header, $model)
    {
        $this->data = $data;
        $this->header = $header;
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        try {
//            foreach ($this->data as $sale) {
//                $importData = array_combine($this->header, $sale);
//                $model = 'App\\Models\\' . $this->model;
//                $model::create($importData);
//            }
//        } catch (\Exception $e) {
//            // bird is clearly not the word
//            $this->failed($e);
//            //throw $e;
//        }
        foreach ($this->data as $sale) {
            $importData = array_combine($this->header, $sale);
            $model = 'App\\Models\\' . $this->model;
            $model::create($importData);
        }

    }

    public function failed(Throwable $exception)
    {
        //$exception->getMessage();
        dd($exception->getMessage());
        return $exception->getMessage();
    }
}
