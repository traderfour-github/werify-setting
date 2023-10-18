<?php

namespace App\Traits;


use function config;

trait Settings
{
    public function get($module, $items = null)
    {
        $loadedSetting = $this->getLoadedSetting($module, $items);
        if ($loadedSetting && $loadedSetting != 'undefined') {
            return $loadedSetting;
        }
        $this->loadSetting($module);
        $loadedSetting = $this->getLoadedSetting($module, $items);
        if ($loadedSetting && $loadedSetting != 'undefined') {
            return $loadedSetting;
        } else {
            if($loadedSetting === false)
            {
                return null;
            }
            if ($loadedSetting == 'undefined') {
                return null;
            } else {
                return null;
            }
        }
    }

    public function set($module, $arrayData)
    {
        if (!isset(self::$_Settings[$module])) {
            $this->loadSetting($module);
        }
        $this->updateSetting($module, $arrayData);
        $this->saveSetting($module);
    }

    public function deleteSetting($module, $items)
    {
        if ($items) {
            $aItems = explode(".", $items);
            $count  = count($aItems);
            $this->loadSetting($module);
            if (isset(self::$_Settings[$module])) {
                switch ($count) {
                    case 1:
                        unset(self::$_Settings[$module][$aItems[0]]);
                        break;
                    case 2:
                        unset(self::$_Settings[$module][$aItems[0]][$aItems[1]]);
                        break;
                    case 3:
                        unset(self::$_Settings[$module][$aItems[0]][$aItems[1]][$aItems[2]]);
                        break;
                    case 4:
                        unset(self::$_Settings[$module][$aItems[0]][$aItems[1]][$aItems[2]][$aItems[3]]);
                        break;
                    case 5:
                        unset(self::$_Settings[$module][$aItems[0]][$aItems[1]][$aItems[2]][$aItems[3]][$aItems[4]]);
                        break;
                }
                $this->saveSetting($module);
            }
        }
    }

    private function loadSetting($module)
    {
        $aData = $this->getDatabaseSetting($module);
        if ($aData) {
            self::$_Settings[$module] = $aData;
        } else {
            $aData = $this->recoveryFromConfig($module);
            if ($aData) {
                self::$_Settings[$module] = $aData;
                $this->saveSetting($module);
            } else {
                self::$_Settings[$module] = array();
            }
        }
    }

    private function updateSetting($module, $arrayData)
    {
        $update = $this->ItemsUpdate(self::$_Settings[$module], $arrayData);
        if ($update) {
            self::$_Settings[$module] = $update;
        }
    }

    private function ItemsUpdate($oldData, $newData)
    {
        $aData = $oldData;
        if (is_array($newData)) {
            foreach ($newData as $itm => $val) {
                if (is_array($val)) {
                    if (!isset($aData[$itm])) {
                        $aData[$itm] = $val;
                    } elseif (is_array($aData[$itm])) {
                        $aData[$itm] = $this->ItemsUpdate($aData[$itm], $val);
                    }
                } else {
                    $aData[$itm] = $val;
                }
            }
            return $aData;
        }
        return false;
    }

    private function recoveryFromConfig($module)
    {
        $conf = config($module);
        if ($conf) {
            return $conf;
        }
        return array();
    }

    private function getLoadedSetting($module, $item = null)
    {
        if ($item) {
            $aItems = explode(".", $item);
            $count  = count($aItems);
            if (isset(self::$_Settings[$module])) {
                $key = self::$_Settings[$module];
                for ($i = 0; $i < $count; $i++) {
                    if (isset($key[$aItems[$i]])) {
                        $key = $key[$aItems[$i]]?$key[$aItems[$i]]:null;
                    } else {
                        $key = array();
                        break;
                    }
                }
                if ($key) {
                    return $key;
                }
                if($key === null){
                    return false;
                }
                return 'undefined';
            }
        } else {
            if (isset(self::$_Settings[$module])) {
                return self::$_Settings[$module];
            }
        }
        return null;
    }
}
