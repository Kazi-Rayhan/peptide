<?php

namespace App\Constants;

class Country
{
    public static function regions(): array
    {
        return [
            'all' => 'All Countries',
            // Africa
            'northern_africa' => 'Northern Africa',
            'sub_saharan_africa' => 'Sub-Saharan Africa',
            'eastern_africa' => 'Eastern Africa',
            'middle_africa' => 'Middle Africa',
            'southern_africa' => 'Southern Africa',
            'western_africa' => 'Western Africa',
            // Americas
            'caribbean' => 'Caribbean',
            'central_america' => 'Central America',
            'north_america' => 'North America',
            'south_america' => 'South America',
            // Asia
            'central_asia' => 'Central Asia',
            'east_asia' => 'East Asia',
            'south_asia' => 'South Asia',
            'southeast_asia' => 'Southeast Asia',
            'western_asia' => 'Western Asia',
            // Europe
            'eastern_europe' => 'Eastern Europe',
            'northern_europe' => 'Northern Europe',
            'southern_europe' => 'Southern Europe',
            'western_europe' => 'Western Europe',
            'nordic' => 'Nordic Countries',
            // Oceania
            'australia_and_new_zealand' => 'Australia and New Zealand',
            'melanesia' => 'Melanesia',
            'micronesia' => 'Micronesia',
            'polynesia' => 'Polynesia',
        ];
    }

    public static function countriesByRegion(): array
    {
        return [
            // Africa
            'northern_africa' => [
                'DZ' => 'Algeria', 'EG' => 'Egypt', 'LY' => 'Libya', 'MA' => 'Morocco', 'SD' => 'Sudan', 'TN' => 'Tunisia', 'EH' => 'Western Sahara',
            ],
            'sub_saharan_africa' => [
                // All Sub-Saharan countries (for completeness, but not used for direct lookup)
            ],
            'eastern_africa' => [
                'BI' => 'Burundi', 'KM' => 'Comoros', 'DJ' => 'Djibouti', 'ER' => 'Eritrea', 'ET' => 'Ethiopia', 'KE' => 'Kenya', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MZ' => 'Mozambique', 'RE' => 'Réunion', 'RW' => 'Rwanda', 'SC' => 'Seychelles', 'SO' => 'Somalia', 'SS' => 'South Sudan', 'TZ' => 'Tanzania', 'UG' => 'Uganda', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe',
            ],
            'middle_africa' => [
                'AO' => 'Angola', 'CM' => 'Cameroon', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CG' => 'Congo', 'CD' => 'Congo (Democratic Republic)', 'GQ' => 'Equatorial Guinea', 'GA' => 'Gabon', 'ST' => 'Sao Tome and Principe',
            ],
            'southern_africa' => [
                'BW' => 'Botswana', 'LS' => 'Lesotho', 'NA' => 'Namibia', 'ZA' => 'South Africa', 'SZ' => 'Eswatini',
            ],
            'western_africa' => [
                'BJ' => 'Benin', 'BF' => 'Burkina Faso', 'CV' => 'Cape Verde', 'CI' => "Côte d'Ivoire", 'GM' => 'Gambia', 'GH' => 'Ghana', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'LR' => 'Liberia', 'ML' => 'Mali', 'MR' => 'Mauritania', 'NE' => 'Niger', 'NG' => 'Nigeria', 'SH' => 'Saint Helena', 'SN' => 'Senegal', 'SL' => 'Sierra Leone', 'TG' => 'Togo',
            ],
            // Americas
            'caribbean' => [
                'AG' => 'Antigua and Barbuda', 'BS' => 'Bahamas', 'BB' => 'Barbados', 'CU' => 'Cuba', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'GD' => 'Grenada', 'HT' => 'Haiti', 'JM' => 'Jamaica', 'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'VC' => 'Saint Vincent and the Grenadines', 'TT' => 'Trinidad and Tobago', 'BZ' => 'Belize', 'GP' => 'Guadeloupe', 'MQ' => 'Martinique', 'SX' => 'Sint Maarten', 'BL' => 'Saint Barthelemy', 'MF' => 'Saint Martin', 'AW' => 'Aruba', 'CW' => 'Curacao', 'TC' => 'Turks and Caicos Islands', 'VG' => 'British Virgin Islands', 'VI' => 'U.S. Virgin Islands', 'MS' => 'Montserrat', 'AI' => 'Anguilla', 'BM' => 'Bermuda', 'KY' => 'Cayman Islands', 'TC' => 'Turks and Caicos Islands',
            ],
            'central_america' => [
                'CR' => 'Costa Rica', 'SV' => 'El Salvador', 'GT' => 'Guatemala', 'HN' => 'Honduras', 'NI' => 'Nicaragua', 'PA' => 'Panama',
            ],
            'north_america' => [
                'CA' => 'Canada', 'US' => 'United States', 'MX' => 'Mexico', 'GL' => 'Greenland',
            ],
            'south_america' => [
                'AR' => 'Argentina', 'BO' => 'Bolivia', 'BR' => 'Brazil', 'CL' => 'Chile', 'CO' => 'Colombia', 'EC' => 'Ecuador', 'FK' => 'Falkland Islands', 'GF' => 'French Guiana', 'GY' => 'Guyana', 'PY' => 'Paraguay', 'PE' => 'Peru', 'SR' => 'Suriname', 'UY' => 'Uruguay', 'VE' => 'Venezuela',
            ],
            // Asia
            'central_asia' => [
                'KZ' => 'Kazakhstan', 'KG' => 'Kyrgyzstan', 'TJ' => 'Tajikistan', 'TM' => 'Turkmenistan', 'UZ' => 'Uzbekistan',
            ],
            'east_asia' => [
                'CN' => 'China', 'HK' => 'Hong Kong', 'JP' => 'Japan', 'KP' => 'North Korea', 'KR' => 'South Korea', 'MO' => 'Macau', 'MN' => 'Mongolia', 'TW' => 'Taiwan',
            ],
            'south_asia' => [
                'AF' => 'Afghanistan', 'BD' => 'Bangladesh', 'BT' => 'Bhutan', 'IN' => 'India', 'IR' => 'Iran', 'LK' => 'Sri Lanka', 'MV' => 'Maldives', 'NP' => 'Nepal', 'PK' => 'Pakistan',
            ],
            'southeast_asia' => [
                'BN' => 'Brunei', 'KH' => 'Cambodia', 'ID' => 'Indonesia', 'LA' => 'Laos', 'MY' => 'Malaysia', 'MM' => 'Myanmar', 'PH' => 'Philippines', 'SG' => 'Singapore', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'VN' => 'Vietnam',
            ],
            'western_asia' => [
                'AM' => 'Armenia', 'AZ' => 'Azerbaijan', 'BH' => 'Bahrain', 'CY' => 'Cyprus', 'GE' => 'Georgia', 'IQ' => 'Iraq', 'IL' => 'Israel', 'JO' => 'Jordan', 'KW' => 'Kuwait', 'LB' => 'Lebanon', 'OM' => 'Oman', 'PS' => 'Palestine', 'QA' => 'Qatar', 'SA' => 'Saudi Arabia', 'SY' => 'Syria', 'TR' => 'Turkey', 'AE' => 'United Arab Emirates', 'YE' => 'Yemen',
            ],
            // Europe
            'eastern_europe' => [
                'BY' => 'Belarus', 'BG' => 'Bulgaria', 'CZ' => 'Czech Republic', 'HU' => 'Hungary', 'PL' => 'Poland', 'MD' => 'Moldova', 'RO' => 'Romania', 'RU' => 'Russia', 'SK' => 'Slovakia', 'UA' => 'Ukraine',
            ],
            'northern_europe' => [
                'EE' => 'Estonia', 'IE' => 'Ireland', 'LV' => 'Latvia', 'LT' => 'Lithuania', 'GB' => 'United Kingdom',
            ],
            'southern_europe' => [
                'AL' => 'Albania', 'AD' => 'Andorra', 'BA' => 'Bosnia and Herzegovina', 'HR' => 'Croatia', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'IT' => 'Italy', 'MT' => 'Malta', 'ME' => 'Montenegro', 'MK' => 'North Macedonia', 'PT' => 'Portugal', 'SM' => 'San Marino', 'RS' => 'Serbia', 'SI' => 'Slovenia', 'ES' => 'Spain', 'VA' => 'Holy See',
            ],
            'western_europe' => [
                'AT' => 'Austria', 'BE' => 'Belgium', 'FR' => 'France', 'DE' => 'Germany', 'LI' => 'Liechtenstein', 'LU' => 'Luxembourg', 'MC' => 'Monaco', 'NL' => 'Netherlands', 'CH' => 'Switzerland',
            ],
            'nordic' => [
                'DK' => 'Denmark', 'FI' => 'Finland', 'IS' => 'Iceland', 'NO' => 'Norway', 'SE' => 'Sweden', 'AX' => 'Aland Islands',
            ],
            // Oceania
            'australia_and_new_zealand' => [
                'AU' => 'Australia', 'NZ' => 'New Zealand',
            ],
            'melanesia' => [
                'FJ' => 'Fiji', 'NC' => 'New Caledonia', 'PG' => 'Papua New Guinea', 'SB' => 'Solomon Islands', 'VU' => 'Vanuatu',
            ],
            'micronesia' => [
                'FM' => 'Micronesia', 'GU' => 'Guam', 'KI' => 'Kiribati', 'MH' => 'Marshall Islands', 'NR' => 'Nauru', 'MP' => 'Northern Mariana Islands', 'PW' => 'Palau',
            ],
            'polynesia' => [
                'AS' => 'American Samoa', 'CK' => 'Cook Islands', 'PF' => 'French Polynesia', 'NU' => 'Niue', 'PN' => 'Pitcairn', 'WS' => 'Samoa', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TV' => 'Tuvalu', 'WF' => 'Wallis and Futuna',
            ],
        ];
    }

    public static function allCountries(): array
    {
        $countriesByRegion = self::countriesByRegion();
        return array_merge(...array_values($countriesByRegion));
    }

    public static function statesCountries(): array
    {
        // List of country codes that have states/provinces
        return [
            'US', // United States
            'CA', // Canada
            'AU', // Australia
            'BR', // Brazil
            'IN', // India
            'MX', // Mexico
            'CN', // China
            // Add more as needed
        ];
    }

    public static function statesByCountry(): array
    {
        return [
            'US' => [
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Delaware',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucky',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'NC' => 'North Carolina',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
            ],
            'CA' => [
                'Alberta' => 'AB',
                'British Columbia' => 'BC',
                'Manitoba' => 'MB',
                'New Brunswick' => 'NB',
                'Newfoundland and Labrador' => 'NL',
                'Nova Scotia' => 'NS',
                'Ontario' => 'ON',
                'Prince Edward Island' => 'PE',
                'Quebec' => 'QC',
                'Saskatchewan' => 'SK',
                'Northwest Territories' => 'NT',
                'Nunavut' => 'NU',
                'Yukon' => 'YT',
            ],
            'AU' => [
                'ACT' => 'Australian Capital Territory',
                'NSW' => 'New South Wales',
                'NT' => 'Northern Territory',
                'QLD' => 'Queensland',
                'SA' => 'South Australia',
                'TAS' => 'Tasmania',
                'VIC' => 'Victoria',
                'WA' => 'Western Australia',
            ],
            'IN' => [
                'AP' => 'Andhra Pradesh',
                'AR' => 'Arunachal Pradesh',
                'AS' => 'Assam',
                'BR' => 'Bihar',
                'CT' => 'Chhattisgarh',
                'GA' => 'Goa',
                'GJ' => 'Gujarat',
                'HR' => 'Haryana',
                'HP' => 'Himachal Pradesh',
                'JH' => 'Jharkhand',
                'KA' => 'Karnataka',
                'KL' => 'Kerala',
                'MP' => 'Madhya Pradesh',
                'MH' => 'Maharashtra',
                'MN' => 'Manipur',
                'ML' => 'Meghalaya',
                'MZ' => 'Mizoram',
                'NL' => 'Nagaland',
                'OR' => 'Odisha',
                'PB' => 'Punjab',
                'RJ' => 'Rajasthan',
                'SK' => 'Sikkim',
                'TN' => 'Tamil Nadu',
                'TG' => 'Telangana',
                'TR' => 'Tripura',
                'UP' => 'Uttar Pradesh',
                'UK' => 'Uttarakhand',
                'WB' => 'West Bengal',
                'AN' => 'Andaman and Nicobar Islands',
                'CH' => 'Chandigarh',
                'DN' => 'Dadra and Nagar Haveli and Daman and Diu',
                'DL' => 'Delhi',
                'JK' => 'Jammu and Kashmir',
                'LA' => 'Ladakh',
                'LD' => 'Lakshadweep',
                'PY' => 'Puducherry',
            ],
        ];
    }

    /**
     * Get the region for a given ISO2 country code.
     *
     * @param string $iso2
     * @return string|null
     */
    public static function regionByCountryCode(string $iso2): ?string
    {
        foreach (self::countriesByRegion() as $region => $countries) {
            if (array_key_exists(strtoupper($iso2), $countries)) {
                return $region;
            }
        }
        return null;
    }

    /**
     * Get all regions for a given ISO2 country code.
     *
     * @param string $iso2
     * @return array
     */
    public static function regionsByCountryCode(string $iso2): array
    {
        $regions = [];
        foreach (self::countriesByRegion() as $region => $countries) {
            if (array_key_exists(strtoupper($iso2), $countries)) {
                $regions[] = $region;
            }
        }
        return $regions;
    }
}
