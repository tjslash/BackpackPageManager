<?php

namespace Tjslash\CtoPageManager;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'tjslash';
    protected $packageName = 'cto-page-manager';
    protected $commands = [];
}
