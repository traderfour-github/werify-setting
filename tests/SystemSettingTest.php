<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Str;

class SystemSettingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSetSystemSetting()
    {
        $this->post( '/system', [ 'key' => 'test_case', 'data' => [ 'a' => 'b' ] ] );

        $this->assertEquals(
            json_encode( [ 'a' => 'b' ] ), $this->response->getContent()
        );
    }

    public function testGetSystemSetting()
    {
        $this->get( '/system/test_case' );

        $this->assertEquals(
            json_encode( [ 'a' => 'b' ] ), $this->response->getContent()
        );
    }

    public function testNotSetGetSystemSetting()
    {
        $this->get( '/system/'.Str::random( 16 ) );

        $this->assertEquals(
            json_encode( [ ] ), $this->response->getContent()
        );
    }
}
