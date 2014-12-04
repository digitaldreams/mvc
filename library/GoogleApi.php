<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GoogleApi{
    
    public static function getLocation($lat = '', $long = '') {
        try {
            if (!empty($long) && !empty($lat)) {
                $geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $long . '&sensor=false');
                return $output = json_decode($geocode);
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public static function countryName($v = '') {
        if (isset($v->results[0]->address_components) && count($v->results[0]->address_components) > 0) {
            $total = count($v->results[0]->address_components);
            $country = '';
            for ($i = 0; $i < $total; $i++) {
                if ($v->results[0]->address_components[$i]->types[0] == 'country') {
                    $country = $v->results[0]->address_components[$i]->long_name;
                    $countryShortName = $v->results[0]->address_components[$i]->short_name;
                }
                if (!empty($country)) {
                    break;
                }
            }
            for ($i = 0; $i < $total; $i++) {
                if ($v->results[0]->address_components[$i]->types[0] == 'locality') {
                    $city = $v->results[0]->address_components[$i]->long_name;
                    $cityId = $i - 1;
                }
                if (!empty($city)) {
                    break;
                }
            }
        }
    }

    public static function getCountryLongName($v = '') {
        $countryLongName = '';
        if (isset($v->results[0]->address_components) && count($v->results[0]->address_components) > 0) {
            $total = count($v->results[0]->address_components);
            for ($i = 0; $i < $total; $i++) {
                if ($v->results[0]->address_components[$i]->types[0] == 'country') {
                    $countryLongName = $v->results[0]->address_components[$i]->long_name;
                }
            }
            if (empty($countryLongName)) {
                for ($i = 0; $i < $total; $i++) {
                    if ($v->results[0]->address_components[$i]->types[0] == 'locality') {
                        $countryLongName = $v->results[0]->address_components[$i]->long_name;
                    }
                }
            }
        }
        return $countryLongName;
    }
    
     public static function getCountryShortName($v = '') {
        $countryShortName = '';
        if (isset($v->results[0]->address_components) && count($v->results[0]->address_components) > 0) {
            $total = count($v->results[0]->address_components);
            for ($i = 0; $i < $total; $i++) {
                if ($v->results[0]->address_components[$i]->types[0] == 'country') {
                    $countryShortName = $v->results[0]->address_components[$i]->short_name;
                }
            }
            if (empty($countryShortName)) {
                for ($i = 0; $i < $total; $i++) {
                    if ($v->results[0]->address_components[$i]->types[0] == 'locality') {
                        $countryShortName = $v->results[0]->address_components[$i]->short_name;
                    }
                }
            }
        }
        return $countryShortName;
    }
}