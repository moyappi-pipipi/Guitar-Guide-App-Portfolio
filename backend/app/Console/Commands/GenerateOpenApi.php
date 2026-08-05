<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;

class GenerateOpenApi extends Command
{
    protected $signature = 'openapi:generate
                            {--format=yaml : Output format (yaml|json)}';

    protected $description = 'Generate OpenAPI document from PHP attributes';

    public function handle(): int
    {
        $format = strtolower((string) $this->option('format'));
        if (! in_array($format, ['yaml', 'json'], true)) {
            $this->error('format must be yaml or json');

            return self::FAILURE;
        }

        $openapi = (new Generator())->generate([
            app_path('OpenApi'),
            app_path('Http/Controllers/Api'),
        ]);

        if ($openapi === null) {
            $this->error('Failed to generate OpenAPI document');

            return self::FAILURE;
        }

        $dir = base_path('openapi');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $yamlPath = $dir.'/openapi.yaml';
        $jsonPath = $dir.'/openapi.json';

        file_put_contents($yamlPath, $openapi->toYaml());
        file_put_contents($jsonPath, $openapi->toJson());

        $this->info("Generated: {$yamlPath}");
        $this->info("Generated: {$jsonPath}");

        return self::SUCCESS;
    }
}
