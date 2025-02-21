<?php

namespace App\Traits;

trait Settings
{
    public function getSettings()
    {
        return \App\Models\SettingsModel::first();
    }

}
