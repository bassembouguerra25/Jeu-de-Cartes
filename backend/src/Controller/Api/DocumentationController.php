<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_doc_')]
class DocumentationController extends AbstractController
{
    #[Route('/doc', name: 'swagger_ui', methods: ['GET'])]
    public function swaggerUi(): Response
    {
        $html = '
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Game API - Documentation</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui.css" />
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            margin:0;
            background: #fafafa;
        }
        .swagger-ui .topbar {
            background-color: #2c3e50;
        }
        .swagger-ui .topbar .download-url-wrapper .select-label {
            color: #fff;
        }
        .swagger-ui .info .title {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: "/api/doc.json",
                dom_id: "#swagger-ui",
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                validatorUrl: null,
                docExpansion: "list",
                filter: true,
                showExtensions: true,
                showCommonExtensions: true
            });
        };
    </script>
</body>
</html>';

        return new Response($html, 200, ['Content-Type' => 'text/html']);
    }

    #[Route('/doc.json', name: 'swagger_json', methods: ['GET'])]
    public function swaggerJson(): JsonResponse
    {
        $documentation = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Card Game API',
                'description' => 'API pour le jeu de cartes',
                'version' => '1.0.0'
            ],
            'paths' => [
                '/api/games/draw' => [
                    'post' => [
                        'summary' => 'Tirer une main de cartes',
                        'description' => 'Tire aléatoirement 10 cartes et les retourne triées',
                        'tags' => ['Games'],
                        'responses' => [
                            '201' => [
                                'description' => 'Main de cartes tirée avec succès',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'success' => [
                                                    'type' => 'boolean',
                                                    'example' => true
                                                ],
                                                'data' => [
                                                    'type' => 'object',
                                                    'properties' => [
                                                        'cards' => [
                                                            'type' => 'array',
                                                            'items' => [
                                                                '$ref' => '#/components/schemas/Card'
                                                            ]
                                                        ],
                                                        'sortedCards' => [
                                                            'type' => 'array',
                                                            'items' => [
                                                                '$ref' => '#/components/schemas/Card'
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            '500' => [
                                'description' => 'Erreur lors du tirage des cartes',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/ErrorResponse'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                '/api/games/rules' => [
                    'get' => [
                        'summary' => 'Obtenir les règles du jeu',
                        'description' => 'Retourne les couleurs, valeurs disponibles et la taille d\'une main',
                        'tags' => ['Games'],
                        'responses' => [
                            '200' => [
                                'description' => 'Règles du jeu récupérées avec succès',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/RulesResponse'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'components' => [
                'schemas' => [
                    'Card' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                                'description' => 'Identifiant unique de la carte'
                            ],
                            'color' => [
                                'type' => 'string',
                                'description' => 'Couleur de la carte (pique, cœur, carreau, trèfle)'
                            ],
                            'value' => [
                                'type' => 'string',
                                'description' => 'Valeur de la carte (As, 2, 3, ..., Roi)'
                            ],
                            'displayName' => [
                                'type' => 'string',
                                'description' => 'Nom d\'affichage de la carte'
                            ]
                        ]
                    ],
                    'HandResponse' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => [
                                'type' => 'boolean',
                                'description' => 'Statut de la requête'
                            ],
                            'data' => [
                                'type' => 'object',
                                'properties' => [
                                    'cards' => [
                                        'type' => 'array',
                                        'items' => [
                                            '$ref' => '#/components/schemas/Card'
                                        ]
                                    ],
                                    'sortedCards' => [
                                        'type' => 'array',
                                        'items' => [
                                            '$ref' => '#/components/schemas/Card'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'RulesResponse' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => [
                                'type' => 'boolean',
                                'description' => 'Statut de la requête'
                            ],
                            'data' => [
                                'type' => 'object',
                                'properties' => [
                                    'colors' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string'
                                        ],
                                        'description' => 'Liste des couleurs disponibles'
                                    ],
                                    'values' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string'
                                        ],
                                        'description' => 'Liste des valeurs disponibles'
                                    ],
                                    'handSize' => [
                                        'type' => 'integer',
                                        'description' => 'Nombre de cartes dans une main'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'ErrorResponse' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => [
                                'type' => 'boolean',
                                'example' => false
                            ],
                            'error' => [
                                'type' => 'string',
                                'description' => 'Message d\'erreur'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return new JsonResponse($documentation);
    }
} 