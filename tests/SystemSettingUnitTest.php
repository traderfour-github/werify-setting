<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Jobs\SettingUpdateJob; 
use App\Jobs\SettingSingleJob; 
use Illuminate\Support\Str;

class SystemSettingUnitTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSetSystemSetting()
    {
        $result = dispatch_now( new SettingUpdateJob( 'test_case', [ 'a' => 'b' ] ) );

        $this->assertEquals(
            [ 'a' => 'b' ], $result
        );
    }

    public function testGetSystemSetting()
    {
        $result = dispatch_now( new SettingSingleJob( 'test_case', [ ] ) );

        $this->assertEquals(
            [ 'a' => 'b' ], $result
        );
    }

    public function testGetNotSetSystemSetting()
    {
        $result = dispatch_now( new SettingSingleJob( Str::random( 16 ), [ ] ) );

        $this->assertEquals(
            [ ], $result
        );
    }
}
