<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\UploadedFile;

class CSVFile
{
    public $file;
    public $data;
    public $header;

    public function __construct(UploadedFile $uploadedFile)
    {
        try {
            $filePath = $uploadedFile->getRealPath();
            $this->file = $filePath;
            $data = array_map('str_getcsv', file($filePath));
            $this->header = array_shift($data);
            $this->data = $data;
        } catch (Exception $e) {
            throw($e);

            return false;
        }
    }
}
