<?php

namespace App\Helpers;

class ContactHelper
{
    public static function correctMobile(string $mobile): string
    {
        // remove leading zeros
        $mobile = ltrim($mobile, '0');
        // remove all non-numeric characters
        $mobile = preg_replace('/\D/', '', $mobile);
        return $mobile;
    }

    public static function countryCodeList(string $defaultCountryName): array
    {
        // Thanks to: giggsey/libphonenumber-for-php
        // this json file we have is a copy of giggsey/libphonenumber-for-php/src/CountryCodeToRegionCodeMap.php
        $file = file_get_contents(database_path('country-codes.json'));
        $data = json_decode($file);
        $data = collect($data)->map(fn (array $item, $key) => [
            'name' => $item[0],
            'code' => (string)$key,
            'defaultSelected' => $item[0] === $defaultCountryName,
        ]);
        return array_values($data->toArray());
    }
}
