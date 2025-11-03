<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        // Cities for Kuwait (country_id = 1)
        $kuwaitCities = [
            'Kuwait City', 'Al Ahmadi', 'Hawalli', 'Mishref', 'Salmiya', 'Jabriya', 'Shuwaikh', 'Riggai'
        ];
        foreach ($kuwaitCities as $city) {
            City::create(['country_id' => 1, 'name' => $city]);
        }

        // Cities for Bahrain (country_id = 2)
        $bahrainCities = [
            'Manama', 'Riffa', 'Muharraq', 'Sitra', "A'ali", 'Isa Town', 'Hamala', 'Zallaq'
        ];
        foreach ($bahrainCities as $city) {
            City::create(['country_id' => 2, 'name' => $city]);
        }

        // Cities for Qatar (country_id = 3)
        $qatarCities = [
            'Doha', 'Al Rayyan', 'Al Wakrah', 'Al Khor', 'Al Daayen', 'Umm Salal', 'Mesaieed'
        ];
        foreach ($qatarCities as $city) {
            City::create(['country_id' => 3, 'name' => $city]);
        }

        // Cities for Saudi Arabia (country_id = 4)
        $ksaCities = [
            'Riyadh', 'Jeddah', 'Mecca', 'Medina', 'Dammam', 'Khobar', 'Taif', 'Buraidah'
        ];
        foreach ($ksaCities as $city) {
            City::create(['country_id' => 4, 'name' => $city]);
        }

        // Cities for United Arab Emirates (country_id = 5)
        $uaeCities = [
            'Abu Dhabi', 'Dubai', 'Sharjah', 'Al Ain', 'Ajman', 'Fujairah', 'Ras Al Khaimah', 'Umm Al Quwain'
        ];
        foreach ($uaeCities as $city) {
            City::create(['country_id' => 5, 'name' => $city]);
        }

        // Cities for Oman (country_id = 6)
        $omanCities = [
            'Muscat', 'Salalah', 'Sohar', 'Nizwa', 'Buraimi', 'Sur', 'Ibra', 'Ibri'
        ];
        foreach ($omanCities as $city) {
            City::create(['country_id' => 6, 'name' => $city]);
        }
    }
}
