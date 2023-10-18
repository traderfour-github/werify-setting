<?php

namespace App\Repositories;


interface SettingsRepositoryInterface
{
	public function getSetting( $key, $items );
	public function setSetting( $key, $data );
}