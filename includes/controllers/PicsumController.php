<?php
namespace App\Controllers;

use App\Models\PicsumDownloader;

class PicsumController {
    public function index() {
        require __DIR__ . '/../views/picsum/index.php';
    }

    public function download() {
        try {
            $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 75;
            $downloader = new PicsumDownloader($limit);
            $csv = $downloader->downloadAndConvert();
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="picsum_images.csv"');
            header('Content-Length: ' . strlen($csv));
            header('Cache-Control: no-cache, must-revalidate');
            
            echo $csv;
            exit;
        } catch (\Exception $e) {
            header('Location: /picsum?error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}