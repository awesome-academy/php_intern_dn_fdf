<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\City;

class CityTest extends TestCase
{
    public function testCitiesConfig()
    {
        $coloumnCheck = [
            'name',
        ];

        $this->assertEquals($coloumnCheck, (new City)->getFillable());
    }
}
