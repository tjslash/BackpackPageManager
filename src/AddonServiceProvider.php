<?php

namespace Tjslash\BackpackPageManager;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'tjslash';
    protected $packageName = 'backpack-page-manager';
    protected $commands = [];
}
