<?php

namespace TalentFlow\Admin;

class Settings
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    public function addMenu(): void
    {
        add_submenu_page(
            'talentflow-ai',
            'Settings',
            'Settings',
            'manage_options',
            'talentflow-settings',
            [$this, 'render']
        );
    }

    public function registerSettings(): void
    {
        register_setting(
            'talentflow_settings',
            'talentflow_api_url'
        );

        register_setting(
            'talentflow_settings',
            'talentflow_timeout'
        );
    }

    public function render(): void
    {
        ?>
        <div class="wrap">

            <h1>TalentFlow AI - Settings</h1>

            <form method="post" action="options.php">

                <?php
                settings_fields('talentflow_settings');
                do_settings_sections('talentflow_settings');
                ?>

                <table class="form-table">

                    <tr>
                        <th scope="row">
                            API URL
                        </th>

                        <td>
                            <input
                                type="text"
                                name="talentflow_api_url"
                                value="<?= esc_attr(get_option('talentflow_api_url', 'http://api:8000')); ?>"
                                class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            Timeout (seconds)
                        </th>

                        <td>
                            <input
                                type="number"
                                min="1"
                                max="30"
                                name="talentflow_timeout"
                                value="<?= esc_attr(get_option('talentflow_timeout', 5)); ?>">
                        </td>
                    </tr>

                </table>

                <?php submit_button(); ?>

            </form>

        </div>
        <?php
    }
}