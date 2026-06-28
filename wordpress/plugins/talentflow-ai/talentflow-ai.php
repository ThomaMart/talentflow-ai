<?php
/**
 * Plugin Name: TalentFlow AI
 * Plugin URI: https://github.com/ThomaMart/talentflow-ai
 * Description: AI-powered recruitment platform for WordPress.
 * Version: 0.1.0
 * Author: Thomas Martin
 * License: MIT
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use TalentFlow\Core\Plugin;

$plugin = new Plugin();
$plugin->boot();