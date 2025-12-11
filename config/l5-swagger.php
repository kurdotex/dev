<?php

return [
    'default' => 'default',

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'DEV',
            ],

            'routes' => [
                'api' => 'api/documentation',
            ],

            'paths' => [
                'docs' => storage_path('api-docs'),

                'annotations' => [
                    base_path('app'),
                    base_path('app/Http/Controllers'),
                    base_path('app/Swagger'),
                ],

                'base' => base_path(),
                'excludes' => [],
            ],

            'constants' => [
                'L5_SWAGGER_CONST_HOST' => env('APP_URL', 'http://localhost'),
            ],

            'proxy' => false,
            'operations_sort' => 'alpha',
            'additional_config_url' => null,
            'validator_url' => null,
        ],
    ],

    'defaults' => [

        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],

        'paths' => [
            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',
            'format_to_save_as_json' => true,
            'format_to_save_as_yaml' => false,

            'annotations' => [
                app_path(),
            ],

            'views' => 'l5-swagger::index',
        ],

        'scanOptions' => [
            'analyser' => null,
            'analysis' => null,
            'processors' => [],
            'pattern' => null,
            'exclude' => [],
            'open_api_spec_version' => '3.0.0',
        ],

        'security' => [
            'bearerAuth' => [
                'type' => 'http',
                'description' => 'Enter token in format (Bearer <token>)',
                'scheme' => 'bearer',
                'bearerFormat' => 'JWT',
            ],
        ],

        'securityDefinitions' => [
            'securitySchemes' => [],
        ],

        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        'generate_on_command' => env('L5_SWAGGER_GENERATE_ON_COMMAND', true),

        'swagger_ui_assets_path' => env(
            'L5_SWAGGER_UI_ASSETS_PATH',
            'vendor/swagger-api/swagger-ui/dist/'
        ),

        'presets' => [
            \L5Swagger\Http\Middleware\ConfigMerger::class,
            \L5Swagger\Http\Middleware\InjectAuthData::class,
        ],
    ],
];
