<?php

namespace TalentFlow\Controllers;

class CVController
{
    public function register(): void
    {
        add_action(
            'rest_api_init',
            [$this, 'registerRoutes']
        );
    }

    public function registerRoutes(): void
    {
        register_rest_route(
            'talentflow/v1',
            '/analyze',
            [
                'methods'             => 'POST',
                'callback'            => [$this, 'analyze'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ]
        );
    }

    public function analyze(\WP_REST_Request $request): \WP_REST_Response
    {
        return new \WP_REST_Response([
            'success' => true,
            'message' => 'REST API operational.'
        ]);
    }
}