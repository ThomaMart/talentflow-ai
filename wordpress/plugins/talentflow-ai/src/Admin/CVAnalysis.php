<?php

namespace TalentFlow\Admin;

use TalentFlow\Api\Client;

class CVAnalysis
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
    }

    public function addMenu(): void
    {
        add_submenu_page(
            'talentflow-ai',
            'CV Analysis',
            'CV Analysis',
            'manage_options',
            'talentflow-cv-analysis',
            [$this, 'render']
        );
    }

    public function render(): void
    {
        $result = null;

        if (
            isset($_POST['talentflow_analyze']) &&
            check_admin_referer('talentflow_cv_analysis')
        ) {
            $client = new Client();
            $result = $client->analyzeCV();
        }

        ?>

        <div class="wrap">

            <h1>CV Analysis</h1>

            <form method="post">

                <?php wp_nonce_field('talentflow_cv_analysis'); ?>

                <?php submit_button('Analyze CV', 'primary', 'talentflow_analyze'); ?>

            </form>

            <?php if ($result) : ?>

                <hr>

                <?php if ($result['success']) : ?>

                    <?php $cv = $result['body']; ?>

                    <h2>Analysis Result</h2>

                    <table class="widefat striped">

                        <tbody>

                            <tr>
                                <th width="220">Candidate</th>
                                <td><?= esc_html($cv['candidate']) ?></td>
                            </tr>

                            <tr>
                                <th>Experience</th>
                                <td><?= esc_html($cv['experience']) ?> years</td>
                            </tr>

                            <tr>
                                <th>Score</th>
                                <td><strong><?= esc_html($cv['score']) ?>/100</strong></td>
                            </tr>

                            <tr>
                                <th>Summary</th>
                                <td><?= esc_html($cv['summary']) ?></td>
                            </tr>

                            <tr>
                                <th>Skills</th>
                                <td>

                                    <ul>

                                        <?php foreach ($cv['skills'] as $skill) : ?>

                                            <li><?= esc_html($skill) ?></li>

                                        <?php endforeach; ?>

                                    </ul>

                                </td>
                            </tr>

                        </tbody>

                    </table>

                <?php else : ?>

                    <div class="notice notice-error inline">
                        <p><?= esc_html($result['message']) ?></p>
                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

        <?php
    }
}