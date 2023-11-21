<?php

declare(strict_types = 1);

// Your Code

function getCsv(){
    $files = scandir(FILES_PATH);
    $csvs = [];

    foreach($files as $file){
        if (is_file(FILES_PATH . $file)){
            $csvs[] = readCsv(FILES_PATH . $file);
        }
    }

    $merged = call_user_func_array('array_merge', $csvs);

    return $merged;
}

function readCsv($filepath){
    $csvData = array_map('str_getcsv', file($filepath));
    array_walk($csvData, function(&$a) use ($csvData) {
        $a = array_combine($csvData[0], $a);
    });
    array_shift($csvData);

    return $csvData;
}

function normalizeAmounts(){
    $amounts = array_map(fn($row) => $row['Amount'], getCsv());

    foreach($amounts as &$amount){
        $amount = str_replace('$', '', $amount);
        $amount = str_replace(',', '', $amount);
        $amount = floatval($amount);
    }

    return $amounts;
}

function getPositive(){
    $amounts = normalizeAmounts();

    $positive = array_reduce($amounts, fn($carry, $item) => $carry + ($item >= 0 ? $item : 0));

    return $positive;
}

function getNegative(){
    $amounts = normalizeAmounts();

    $negative = array_reduce($amounts, fn($carry, $item) => $carry + ($item < 0 ? abs($item) : 0));

    return $negative;
}

function getTotal(){
    return getPositive() - getNegative();
}

function getClass($amount){
    return $amount[0] == '-' ? 'red' : 'green';
}

function formatDate($date){
    $dateTime = DateTime::createFromFormat('m/d/Y', $date);
    $formattedDate = $dateTime->format('M j, Y');

    return "$formattedDate";
}