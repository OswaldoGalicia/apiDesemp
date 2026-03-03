<?php

class GetEnv{

    public static function getDbEnv(){
        $filePath = __DIR__.'/../../.env';
        if(!file_exists($filePath)){
            echo $filePath;
            return false;
        }
        $lines = file_get_contents($filePath);
        foreach(explode("\n", $lines) as $line){
            if( str_starts_with(trim($line), '#') || trim($line) === '' ){
                continue;
            }
            putenv(trim($line));
        }
        return true;
    }
    
}