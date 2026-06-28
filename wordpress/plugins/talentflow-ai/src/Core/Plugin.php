<?php

namespace TalentFlow\Core;

use TalentFlow\Admin\Dashboard;
use TalentFlow\Admin\Settings;
use TalentFlow\Admin\CVAnalysis;
use TalentFlow\Controllers\CVController;

class Plugin
{
    private Dashboard $dashboard;
    private Settings $settings;
    private CVAnalysis $cvAnalysis;
    private CVController $cvController;

    public function __construct()
    {
        $this->dashboard = new Dashboard();
        $this->settings = new Settings();
        $this->cvAnalysis = new CVAnalysis();
        $this->cvController = new CVController();
    }

    public function boot(): void
    {
        $this->dashboard->register();
        $this->settings->register();
        $this->cvAnalysis->register();
        $this->cvController->register();
    }
}