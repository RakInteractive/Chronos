<?php

namespace App\Hooks;

use App\Models\Hook as HookModel;
use App\Models\LogEntry;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Teams extends Hook {
    public function run(LogEntry $logEntry, HookModel $hook): void {
        $config = $this->validateConfig($hook, [
            'url' => 'required|url',
        ]);

        if (empty($config)) {
            return;
        }

        $card = $this->generateCard($logEntry);

        try {
            $response = Http::post($config['url'], $card);

            if ($response->failed()) {
                $hook->update(['enabled' => false]);
                Log::warning("Disabling hook ($hook->id) $hook->name due to error: " . $response->body());
                return;
            }
        } catch (ConnectionException $e) {
            $hook->update(['enabled' => false]);
            Log::warning("Disabling hook ($hook->id) $hook->name due to connection error: " . $e->getMessage());
            return;
        }
    }

    private function generateCard(LogEntry $logEntry): array {
        $iconType = match ($logEntry->level) {
            'warning' => 'Warning',
            'error', 'critical', 'alert', 'emergency' => 'Attention',
            default => 'Default'
        };

        $iconName = match ($logEntry->level) {
            'warning' => 'Warning',
            'error', 'critical', 'alert', 'emergency' => 'ErrorCircle',
            default => 'Info'
        };

        function formatJsonIfPossible($content) {
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
            return $content;
        }

        $message = $logEntry->title;
        $labels = implode(', ', $logEntry->labels ?? []);
        $content = formatJsonIfPossible($logEntry->content);
        $context = json_encode($logEntry->context, JSON_PRETTY_PRINT);
        $errorUrl = config('app.url') . "/token/$logEntry->token_id?entry=" . $logEntry->id;

        return [
            'type' => 'message',
            'attachments' => [
                [
                    'contentType' => 'application/vnd.microsoft.card.adaptive',
                    'contentUrl' => null,
                    'content' => [
                        'type' => 'AdaptiveCard',
                        '$schema' => 'https://adaptivecards.io/schemas/adaptive-card.json',
                        'speak' => 'ErrorMessage',
                        'version' => '1.5',
                        "msteams" => ["width" => "full"],
                        'body' => [
                            [
                                'type' => 'ColumnSet',
                                'columns' => [
                                    [
                                        'type' => 'Column',
                                        'width' => '50px',
                                        'items' => [
                                            [
                                                'type' => 'Icon',
                                                'color' => $iconType,
                                                'name' => $iconName
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'Column',
                                        'items' => [
                                            [
                                                'type' => 'TextBlock',
                                                'text' => $message,
                                                'size' => 'ExtraLarge',
                                                'height' => 'stretch'
                                            ]
                                        ],
                                        'width' => 'stretch'
                                    ]
                                ]
                            ],
                            [
                                'type' => 'ColumnSet',
                                'columns' => [
                                    [
                                        'type' => 'Column',
                                        'width' => '50px',
                                        'items' => [
                                            [
                                                'type' => 'TextBlock',
                                                'text' => 'Token'
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'Column',
                                        'items' => [
                                            [
                                                'type' => 'TextBlock',
                                                'text' => $logEntry->token->name
                                            ]
                                        ],
                                        'width' => 'stretch'
                                    ]
                                ],
                            ],
                            [
                                'type' => 'ColumnSet',
                                'columns' => [
                                    [
                                        'type' => 'Column',
                                        'width' => '50px',
                                        'items' => [
                                            [
                                                'type' => 'TextBlock',
                                                'text' => 'Labels'
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'Column',
                                        'items' => [
                                            [
                                                'type' => 'TextBlock',
                                                'text' => $labels
                                            ]
                                        ],
                                        'width' => 'stretch'
                                    ]
                                ],
                                'minHeight' => '30px'
                            ],
                            [
                                'type' => 'Container',
                                'items' => [
                                    [
                                        'type' => 'TextBlock',
                                        'text' => 'Content',
                                        'size' => 'Large'
                                    ],
                                    [
                                        'type' => 'CodeBlock',
                                        'codeSnippet' => $content,
                                        'language' => 'Json'
                                    ]
                                ],
                                'spacing' => 'None',
                                'style' => 'emphasis'
                            ],
                            [
                                'type' => 'Container',
                                'items' => [
                                    [
                                        'type' => 'TextBlock',
                                        'text' => 'Context',
                                        'size' => 'Large'
                                    ],
                                    [
                                        'type' => 'CodeBlock',
                                        'codeSnippet' => $context,
                                        'language' => 'Json'
                                    ]
                                ],
                                'style' => 'emphasis'
                            ],
                            [
                                'type' => 'ActionSet',
                                'actions' => [
                                    [
                                        'type' => 'Action.OpenUrl',
                                        'title' => 'Show',
                                        'tooltip' => 'Open in chronos',
                                        'url' => $errorUrl,
                                        'style' => 'positive',
                                        'iconUrl' => 'icon:Eye'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
