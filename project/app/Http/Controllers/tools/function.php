<?php

function inputs($input) {
    return @htmlspecialchars(@trim($input));
}

function txtempty($data) {
    if ($data) {
        return $data;
    } else {
        return null;
    }
}

function boolstatus($data) {
    if (
            strcmp($data, "A") == 0 ||
            strcmp($data, "I") == 0 ||
            strcmp($data, "trash") == 0
    ) {
        return true;
    } else {
        return false;
    }
}

function objectToArray(&$object) {
    return @json_decode(json_encode($object), true);
}

function probabilidaddemuerteanio($fecha_nacimiento) {
    $prob = 73;
    return date("Y", strtotime($fecha_nacimiento . "+ " . $prob . " year"));
}

function probabilidaddemuerteedad($edad) {
    $prob = 73;
    $edadmuerte = intval($edad) - intval($prob);
    if ($edadmuerte < 0) {
        $edadmuerte = $edadmuerte * -1;
    }
    return $edadmuerte;
}

function Stand_Deviation($arr) {
    $num_of_elements = count($arr);

    $variance = 0.0;

    // calculating mean using array_sum() method
    $average = array_sum($arr) / $num_of_elements;

    foreach ($arr as $i) {
        // sum of squares of differences between 
        // all numbers and means.
        $variance += pow(($i - $average), 2);
    }

    return (float) sqrt($variance / $num_of_elements);
}
