<?php

namespace App\Helpers;

class Country
{
    public static function countryList()
    {
        $filePath = storage_path('app/countries.json');

        // Check if the file exists
        if (!file_exists($filePath)) {
            // Handle the case when the file is not found
            toastr()->error('JSON file not found!', 404);
            return;
        }

        // Read the contents of the JSON file as a string
        $jsonString = file_get_contents($filePath);

        // Parse the JSON string into a PHP array
        $dataArray = json_decode($jsonString, true);

        // Check if JSON decoding was successful
        if ($dataArray === null) {
            // Handle the case when JSON parsing fails
            return response()->json(['error' => 'Invalid JSON format'], 500);
        }

        return $dataArray;
    }
}
