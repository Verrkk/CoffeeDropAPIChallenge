<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Location;
use League\Csv\Reader;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csv = Reader::createFromPath(database_path('location_data.csv'), 'r');
        
        $csv->setHeaderOffset(0);

        foreach($csv as $record) {
            Location::create([
                'postcode' => $record['postcode'],
                'open_monday'  => $record['open_Monday'] ?: null,
                'open_tuesday'  => $record['open_Tuesday'] ?: null,
                'open_wednesday'  => $record['open_Wednesday'] ?: null,
                'open_thursday'  => $record['open_Thursday'] ?: null,
                'open_friday'  => $record['open_Friday'] ?: null,
                'open_saturday'  => $record['open_Saturday'] ?: null,
                'open_sunday'  => $record['open_Sunday'] ?: null,
                'closed_monday'  => $record['closed_Monday'] ?: null,
                'closed_tuesday'  => $record['closed_Tuesday'] ?: null,
                'closed_wednesday'  => $record['closed_Wednesday'] ?: null,
                'closed_thursday'  => $record['closed_Thursday'] ?: null,
                'closed_friday'  => $record['closed_Friday'] ?: null,
                'closed_saturday'  => $record['closed_Saturday'] ?: null,
                'closed_sunday'  => $record['closed_Sunday'] ?: null,
            ]);
        }
    }
}
