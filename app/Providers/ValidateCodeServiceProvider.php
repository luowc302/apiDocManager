<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

use App\Libs\ValidateCode;
use Illuminate\Support\ServiceProvider;

class ValidateCodeServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton('VrCode', function() {
            return new ValidateCode(80, 30, 4);
        });
    }

}
