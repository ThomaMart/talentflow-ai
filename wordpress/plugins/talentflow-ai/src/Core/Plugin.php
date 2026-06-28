<?php

namespace TalentFlow\Core;

use TalentFlow\Admin\Dashboard;

class Plugin
{
    private Dashboard $dashboard;

    public function __construct()
    {
        $this->dashboard = new Dashboard();
    }

    public function boot(): void
    {
        $this->dashboard->register();
    }
}