<?php

namespace TalentFlow\Admin;

class Dashboard
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
    }

    public function addMenu(): void
    {
        add_menu_page(
            'TalentFlow AI',
            'TalentFlow AI',
            'manage_options',
            'talentflow-ai',
            [$this, 'render'],
            'dashicons-groups',
            30
        );
    }

    public function render(): void
    {
        ?>
        <div class="wrap">
            <h1>🚀 TalentFlow AI</h1>

            <p>Welcome to TalentFlow AI.</p>

            <p>
                AI-powered recruitment platform built with
                WordPress,
                FastAPI,
                Docker
                and OpenAI.
            </p>

            <hr>

            <h2>System status</h2>

            <table class="widefat striped">
                <tbody>
                    <tr>
                        <td>Plugin</td>
                        <td>✅ Loaded</td>
                    </tr>

                    <tr>
                        <td>API</td>
                        <td>⏳ Not connected</td>
                    </tr>

                    <tr>
                        <td>Version</td>
                        <td>0.1.0</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }
}