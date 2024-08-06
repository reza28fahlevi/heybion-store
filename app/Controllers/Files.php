<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;

class Files extends BaseController
{
    public function view($folder,$filename)
    {
        $filePath = WRITEPATH . 'uploads/' . $folder . '/' . $filename;

        // pre($filePath,1);
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($filename);
        }

        $file = new File($filePath);

        // Serve the file
        return $this->response->download($file->getRealPath(), null, true);
    }
}
