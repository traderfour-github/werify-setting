<?php

namespace App\Models;

use Modules\Core\Models\BaseMongoModel;
use Modules\Setting\Traits\Settings;

class UserSetting extends BaseMongoModel
{
    use Settings;
    protected $fillable = ["user_id","model","data"];
    private $_mod = "user";
    private static $_Settings;
    private static $_UserId;


    private function saveSetting( $model )
    {
        if( isset( self::$_Settings[ $model ] ) && self::$_Settings[ $model ] && is_array( self::$_Settings[$model ] ) ) {
            self::updateOrCreate( [ 'user_id' => $this->getUserId(), 'model' => $model ], [ 'data' => self::$_Settings[ $model ] ] );
        }
    }

    private function getDatabaseSetting( $model )
    {
        $DbSetting = self::where( 'user_id', $this->getUserId() )->where( 'model', $model )->first();
        if( $DbSetting ){
            return $DbSetting->data;
        }
        return array();
    }

    private function getUserId()
    {
        if( !self::$_UserId ){
            self::$_UserId = auth()->user()->id;
        }
        return self::$_UserId;
    }

    public function setUserId( $userId )
    {
        if( $userId ) {
            self::$_UserId = $userId;
        }
    }
}
