<?php

namespace App\MQTT;

class ScannerExtractor
{
    protected $attributes = [];
    protected $message;

    public function __construct(string $message) {
        $this->message = $message;
    }

    public function extract()
    {
        // $delimiter = '|';
        // [$barcode, $line, $time] = explode($delimiter, $this->message);
        
        $this->attributes = [
            'barcode' => $this->message,
            // 'line' => $line, 
            // 'time' => $time
        ];

        return $this;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}