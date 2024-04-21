<?php

namespace App\Helpers;

class ContactHelper
{
    /**
     * Correct mobile number
     * This method removes leading zeros and all non-numeric characters from the mobile number
     */
    public static function correctMobile(string $mobile): string
    {
        // remove leading zeros
        $mobile = ltrim($mobile, '0');
        // remove all non-numeric characters
        $mobile = preg_replace('/\D/', '', $mobile);
        return $mobile;
    }

    /**
     * Get country code list
     * This method returns a list of country codes
     */
    public static function countryCodeList(string $defaultCountryName): array
    {
        // Thanks to: giggsey/libphonenumber-for-php
        // this json file we have is a copy of giggsey/libphonenumber-for-php/src/CountryCodeToRegionCodeMap.php
        // read file in database folder
        $file = file_get_contents(database_path('country-codes.json'));
        // decode json file
        $data = json_decode($file);
        $data = collect($data)->map(function (array $item, $key) use ($defaultCountryName) {
            return [
                'name' => $item[0],
                'code' => (string)$key,
                'defaultSelected' => $item[0] === $defaultCountryName,
            ];
        });
        return array_values($data->toArray());
    }
}
