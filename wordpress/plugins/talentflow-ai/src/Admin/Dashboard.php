<?php

namespace TalentFlow\Admin;

use TalentFlow\Api\Client;

class Dashboard
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
    }

    public function addMenu(): void
    {
        add_menu_page(
            page_title: 'TalentFlow AI',
            menu_title: 'TalentFlow AI',
            capability: 'manage_options',
            menu_slug: 'talentflow-ai',
            callback: [$this, 'render'],
            icon_url: 'dashicons-groups',
            position: 30
        );
    }

    public function render(): void
    {
        $client = new Client();
        $health = $client->health();

        $apiStatus = $health['success']
            ? '🟢 Connected'
            : '🔴 Disconnected';

        $apiVersion = $health['body']['version'] ?? '-';
        $apiHealth = $health['body']['status'] ?? '-';

        ?>
        <div class="wrap">

            <h1>🚀 TalentFlow AI</h1>

            <p>
                Modern recruitment platform powered by
                <strong>WordPress</strong>,
                <strong>FastAPI</strong>,
                <strong>Docker</strong>
                and AI.
            </p>

            <hr>

            <h2>API Status</h2>

            <?php if ($health['success']) : ?>

                <table class="widefat striped">
                    <tbody>

                        <tr>
                            <th width="220">Connection</th>
                            <td><?= esc_html($apiStatus) ?></td>
                        </tr>

                        <tr>
                            <th>Health</th>
                            <td><?= esc_html($apiHealth) ?></td>
                        </tr>

                        <tr>
                            <th>Version</th>
                            <td><?= esc_html($apiVersion) ?></td>
                        </tr>

                    </tbody>
                </table>

            <?php else : ?>

                <div class="notice notice-error inline">
                    <p>
                        <strong>Unable to contact FastAPI.</strong><br>
                        <?= esc_html($health['message']) ?>
                    </p>
                </div>

            <?php endif; ?>

            <br>

            <h2>System Status</h2>

            <table class="widefat striped">
                <tbody>

                    <tr>
                        <th width="220">Plugin</th>
                        <td>✅ Loaded</td>
                    </tr>

                    <tr>
                        <th>WordPress</th>
                        <td><?= esc_html(get_bloginfo('version')) ?></td>
                    </tr>

                    <tr>
                        <th>PHP</th>
                        <td><?= esc_html(PHP_VERSION) ?></td>
                    </tr>

                    <tr>
                        <th>API</th>
                        <td><?= esc_html($apiStatus) ?></td>
                    </tr>

                    <tr>
                        <th>Plugin Version</th>
                        <td>0.1.0</td>
                    </tr>

                </tbody>
            </table>

        </div>
        <?php
    }
}