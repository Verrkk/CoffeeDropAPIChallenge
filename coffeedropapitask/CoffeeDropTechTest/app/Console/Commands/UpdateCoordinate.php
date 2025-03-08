<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Location;
use App\Services\PostcodeService;

class UpdateCoordinate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update latitude and longitude for all locations with null values using Postcodes.io API';

    protected $postcodeService;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function __construct(PostcodeService $postcodeService)
    {
        parent::__construct();

        $this->postcodeService = $postcodeService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        
        $locations = Location::whereNull('latitude')
        ->whereNull('longitude')
        ->get();

        $this->info("Found {$locations->count()} locations to update.");

        foreach ($locations as $location) {
            $coordinates = $this->postcodeService->getCoordinates($location->postcode);

            if ($coordinates) {
                $location->latitude = $coordinates['latitude'];
                $location->longitude = $coordinates['longitude'];
                $location->save();

                $this->info("Updated coordinates for postcode {$location->postcode}.");
            } else {
                $this->error("Could not find coordinates for postcode {$location->postcode}.");
            }
        }

        $this->info('Coordinate update process finished!');
    }
}

