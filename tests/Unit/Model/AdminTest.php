<?php

namespace Tests\Unit\Model;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AdminTest extends TestCase
{
    public function testAdminsConfig()
    {
        $coloumnCheck = [
            'fullname',
            'email',
            'password',
            'phone',
            'role',
        ];

        $this->assertEquals($coloumnCheck, (new Admin)->getFillable());
    }
}
