<?php

namespace TalentFlow\Admin;

use TalentFlow\Api\Client;

class CVAnalysis
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets(string $hook): void
    {
        if ($hook !== 'talentflow-ai_page_talentflow-cv-analysis') {
            return;
        }

        wp_enqueue_style(
            'talentflow-admin',
            plugins_url('../../assets/css/admin.css', __FILE__),
            [],
            '0.1.0'
        );
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
            if (
                empty($_FILES['cv_file']) ||
                $_FILES['cv_file']['error'] !== UPLOAD_ERR_OK
            ) {
                $result = [
                    'success' => false,
                    'message' => 'Please select a valid PDF file.'
                ];
            } else {
                $client = new Client();

                $result = $client->analyzeCV(
                    $_FILES['cv_file']['tmp_name']
                );
            }
        }

        require plugin_dir_path(__FILE__) . '../../templates/cv-analysis.php';
    }
}