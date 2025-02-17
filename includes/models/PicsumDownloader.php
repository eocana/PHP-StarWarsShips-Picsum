<?php
namespace App\Models;

class PicsumDownloader {
    private const API_URL = 'https://picsum.photos/v2/list';
    private const MAX_LIMIT = 100;
    private int $limit;
    
    public function __construct(int $limit = 75) {
        if ($limit < 1 || $limit > self::MAX_LIMIT) {
            throw new \InvalidArgumentException("Límite debe estar entre 1 y " . self::MAX_LIMIT);
        }
        $this->limit = $limit;
    }
    
    public function downloadAndConvert(): string {
        $data = $this->fetchData();
        return $this->convertToCsv($data);
    }

    private function fetchData(): array {
        $url = self::API_URL . '?limit=' . $this->limit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    private function convertToCsv(array $data): string {
        $output = fopen('php://temp', 'r+');
        
        // Escribir cabeceras
        fputcsv($output, array_keys($data[0]), ';');
        
        // Escribir datos
        foreach ($data as $row) {
            fputcsv($output, $row, ';');
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }
}