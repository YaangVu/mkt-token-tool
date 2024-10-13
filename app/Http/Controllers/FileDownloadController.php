<?php

namespace App\Http\Controllers;

class FileDownloadController extends Controller
{
    public function downloadKernel()
    {
        $path = storage_path('kernel.tar.gz');

        return response()->download($path);
    }
}
