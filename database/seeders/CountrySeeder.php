<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {

        //  DB::table('countries')->truncate();

        // DB::table('countries')->insert([
        //     [
        //         'name' => 'Kuwait',
        //         'iso_code' => 'KW',
        //         'currency_name' => 'Kuwaiti Dinar',
        //         'currency_code' => 'KWD',
        //         'currency_symbol' => 'د.ك',
        //         'dial_code' => '+965',
        //         'flag' => '🇰🇼',
        //         'flag1'=>'https://flagcdn.com/w40/kw.png',
        //         'exchange_rate_to_kwd' => 1.0000,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Bahrain',
        //         'iso_code' => 'BH',
        //         'currency_name' => 'Bahraini Dinar',
        //         'currency_code' => 'BHD',
        //         'currency_symbol' => '.د.ب',
        //         'dial_code' => '+973',
        //         'flag' => '🇧🇭',
        //         'flag1'=>'https://flagcdn.com/w40/bh.png',
        //         'exchange_rate_to_kwd' => 0.8167,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Qatar',
        //         'iso_code' => 'QA',
        //         'currency_name' => 'Qatari Riyal',
        //         'currency_code' => 'QAR',
        //         'currency_symbol' => 'ر.ق',
        //         'dial_code' => '+974',
        //         'flag' => '🇶🇦',
        //         'flag1'=>'https://flagcdn.com/w40/qa.png',
        //         'exchange_rate_to_kwd' => 0.0900,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Saudi Arabia',
        //         'iso_code' => 'SA',
        //         'currency_name' => 'Saudi Riyal',
        //         'currency_code' => 'SAR',
        //         'currency_symbol' => 'ر.س',
        //         'dial_code' => '+966',
        //         'flag' => '🇸🇦',
        //         'flag1'=>'https://flagcdn.com/w40/sa.png',
        //         'exchange_rate_to_kwd' => 0.0860,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'United Arab Emirates',
        //         'iso_code' => 'AE',
        //         'currency_name' => 'UAE Dirham',
        //         'currency_code' => 'AED',
        //         'currency_symbol' => 'د.إ',
        //         'dial_code' => '+971',
        //         'flag' => '🇦🇪',

        //         'flag1'=>'https://flagcdn.com/w40/ae.png',
        //         'exchange_rate_to_kwd' => 0.0880,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Oman',
        //         'iso_code' => 'OM',
        //         'currency_name' => 'Omani Rial',
        //         'currency_code' => 'OMR',
        //         'currency_symbol' => 'ر.ع.',
        //         'dial_code' => '+968',
        //         'flag' => '🇴🇲',
        //         'flag1'=>'https://flagcdn.com/w40/om.png',
        //         'exchange_rate_to_kwd' => 0.7980,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

$countries = [
    [
        'name' => 'Kuwait',
        'iso_code' => 'KW',
        'currency_name' => 'Kuwaiti Dinar',
        'currency_code' => 'KWD',
        'currency_symbol' => 'د.ك',
        'dial_code' => '+965',
        'flag' => '🇰🇼',
        'flag1' => 'https://flagcdn.com/w40/kw.png',
        'exchange_rate_to_kwd' => 1.0000,
    ],
    [
        'name' => 'Bahrain',
        'iso_code' => 'BH',
        'currency_name' => 'Bahraini Dinar',
        'currency_code' => 'BHD',
        'currency_symbol' => '.د.ب',
        'dial_code' => '+973',
        'flag' => '🇧🇭',
        'flag1' => 'https://flagcdn.com/w40/bh.png',
        'exchange_rate_to_kwd' => 0.8167,
    ],
    [
        'name' => 'Qatar',
        'iso_code' => 'QA',
        'currency_name' => 'Qatari Riyal',
        'currency_code' => 'QAR',
        'currency_symbol' => 'ر.ق',
        'dial_code' => '+974',
        'flag' => '🇶🇦',
        'flag1' => 'https://flagcdn.com/w40/qa.png',
        'exchange_rate_to_kwd' => 0.0900,
    ],
    [
        'name' => 'Saudi Arabia',
        'iso_code' => 'SA',
        'currency_name' => 'Saudi Riyal',
        'currency_code' => 'SAR',
        'currency_symbol' => 'ر.س',
        'dial_code' => '+966',
        'flag' => '🇸🇦',
        'flag1' => 'https://flagcdn.com/w40/sa.png',
        'exchange_rate_to_kwd' => 0.0860,
    ],
    [
        'name' => 'United Arab Emirates',
        'iso_code' => 'AE',
        'currency_name' => 'UAE Dirham',
        'currency_code' => 'AED',
        'currency_symbol' => 'د.إ',
        'dial_code' => '+971',
        'flag' => '🇦🇪',
        'flag1' => 'https://flagcdn.com/w40/ae.png',
        'exchange_rate_to_kwd' => 0.0880,
    ],
    [
        'name' => 'Oman',
        'iso_code' => 'OM',
        'currency_name' => 'Omani Rial',
        'currency_code' => 'OMR',
        'currency_symbol' => 'ر.ع.',
        'dial_code' => '+968',
        'flag' => '🇴🇲',
        'flag1' => 'https://flagcdn.com/w40/om.png',
        'exchange_rate_to_kwd' => 0.7980,
    ],
];

foreach ($countries as $country) {
    DB::table('countries')->updateOrInsert(
        ['name' => $country['name']], // 👈 condition (unique by name)
        array_merge($country, [
            'updated_at' => now(),
            'created_at' => now(),
        ])
    );
}


    }
}