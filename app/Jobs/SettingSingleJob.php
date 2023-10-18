<?php

namespace App\Jobs;

use App\Repositories\SettingsRepositoryInterface;

class SettingSingleJob extends Job
{
	var $settingRepository;

	/**
	 * Create a new Job instance.
	 *
	 * @param        $key
	 * @param string $items
	 */
	public function __construct( public $key, public string $items ='' )
	{
		$this->settingRepository = app()->make( SettingsRepositoryInterface::class );
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		return $this->settingRepository->getSetting( $this->key, $this->items );
	}
}
