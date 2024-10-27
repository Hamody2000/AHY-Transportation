<?php

if (!function_exists('convertNumbersToArabic')) {
    function convertNumbersToArabic($input)
    {
        $westernArabic = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $easternArabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($westernArabic, $easternArabic, $input);
    }
}
