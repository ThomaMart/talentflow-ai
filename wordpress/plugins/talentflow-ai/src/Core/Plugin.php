<?php

namespace TalentFlow\Core;

use TalentFlow\Admin\Dashboard;
use TalentFlow\Admin\Settings;
use TalentFlow\Admin\CVAnalysis;

class Plugin
{
    private Dashboard $dashboard;
    private Settings $settings;
    private CVAnalysis $cvAnalysis;

    public function __construct()
    {
        $this->dashboard = new Dashboard();
        $this->settings = new Settings();
        $this->cvAnalysis = new CVAnalysis();
    }

    public function boot(): void
    {
        $this->dashboard->register();
        $this->settings->register();
        $this->cvAnalysis->register();
    }
}