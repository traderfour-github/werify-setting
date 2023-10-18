<?php

namespace App\Models;

use App\Traits\Settings;

class Setting extends BaseMongoModel
{
    use Settings;
    protected $fillable = [ "model", "data" ];
    private static $_Settings;
    private $_mod = "app";

    private function saveSetting( $model )
    {
        if(isset( self::$_Settings[ $model ] ) && self::$_Settings[ $model ] && is_array( self::$_Settings[ $model ] ) ) {
            self::updateOrCreate( [ 'model' => $model ], [ 'data' => self::$_Settings[ $model ] ] );
        }
    }

    private function getDatabaseSetting( $model )
    {
        $DbSetting = self::where( 'model', $model )->first();
        if( $DbSetting ){
            $aData = $DbSetting->data;
            return $aData;
        }
        return array();
    }
}
