<?php

namespace App\Jobs;

use App\Repositories\SettingsRepositoryInterface;

class SettingUpdateJob extends Job
{
    var $settingRepository;
    var $key;
    var $data;
    /**
     * Create a new Job instance.
     *
     * @return void
     */
    public function __construct( $key,$data )
    {
        $this->settingRepository = app()->make( SettingsRepositoryInterface::class );
        $this->key  = $key;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->settingRepository->setSetting( $this->key, $this->data ); 
        return dispatch_now( new SettingSingleJob( $this->key, [] ) );
    }
}
