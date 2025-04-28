<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $export;
    protected $filename;
    protected $disk;

    public function __construct($export, $filename, $disk = 'public')
    {
        $this->export = $export;
        $this->filename = $filename;
        $this->disk = $disk;
    }

    public function handle()
    {
        Excel::store($this->export, $this->filename, $this->disk);
    }
}
