<?php

class Handler
{
    private $filesDir = 'files';
    private $filePath = '';
    private $stringsDivider = ' ';
    
    /**
     * numbersInFile
     * Разбивает файл на строки и добавляет количество символов в конец строк
     * @return string
     */
    public function numbersInFile() : string {
        $text = file_get_contents($this->filePath);
        $resStrings = [];
        $strings = explode($this->stringsDivider, $text);
        foreach($strings as $string){
            preg_match_all('/\d/', $string, $matches);
            $numbers = count($matches[0]);
            $resStrings[] = "$string = $numbers";
        }
        $result = implode("<br>", $resStrings);
        return $result;
    }
    
    /**
     * fileLoad
     * Загружает файл
     * @return array
     */
    public function fileLoad() : array {
        $result = [];
        if(!empty($_FILES['file']) && $_FILES['file']['type'] = "text/plain"){
            if (!is_dir($this->filesDir)){
                mkdir($this->filesDir);
            }
            $filePath = $this->filesDir . "/" . basename($_FILES['file']['name']);
            if(move_uploaded_file($_FILES['file']['tmp_name'], $filePath)){
                $result = ['success' => "файл загружен"];
                $this->filePath = $filePath;
            }
            else {
                $result = ['error' => "не удалось загрузить файл"];
            }
        }
        else {
            $result = ['error' => "файл не загружен или недопустимый тип файла"];
        }
        return $result;
    }

}