<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class NodeExecutorServices
{
    /**
     * Service untuk mengeksekusi node pada workflow sederhana.
     *
     * Contoh struktur node:
     * - 'type' => salah satu dari: 'log', 'delay'
     * - 'config' => array yang berisi konfigurasi khusus untuk tipe node
     */
    public function execute($node, $context = [])
    {
        $type   = $node['type'] ?? null;
        $config = $node['config'] ?? [];

        switch ($type) {
            case 'log':
                $message = $this->resolveValue($config['message'] ?? '', $context);

                // Menulis ke log dengan level info. Jangan lempar error jika data null.
                Log::info($message);
                return ['message' => $message];

            case 'delay':
                // Node "delay" menunda eksekusi selama beberapa detik.
                // Config:
                // - seconds: integer jumlah detik
                // - default 1detik

                $seconds = (int) ($config['seconds'] ?? 1);
                sleep($seconds);
                return ['delayed' => $seconds,'s'];

            default:
                throw new \Exception("Unknown node type: {$type}");
        }
    }

    private function resolveValue($value, $context)
    {
        if (!is_string($value)) {
            return $value;
        }

        return preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($context) {
            return data_get($context, trim($matches[1]));
        }, $value);
    }
}
