<?php

namespace App\Repositories;

use App\Events\SettingUpdatedEvent;
use App\Models\Setting;

class SettingsRepository implements SettingsRepositoryInterface
{
	public function getSetting( $key, $items )
	{
		return ( new Setting() )->get( $key, $items );
	}

	public function setSetting( $key, $data )
	{
		$result = ( new Setting() )->set( $key, $data );
		event( new SettingUpdatedEvent( $key, $data ) );
		return $result;
	}
}