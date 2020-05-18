<?php

namespace Yuca;

use Illuminate\Filesystem\Filesystem;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

function styles(Finder $finder, array $rules = []): Config
{
    $rules = array_merge(require __DIR__ . '/rules.php', $rules);

    return Config::create()
        ->setFinder($finder)
        ->setRiskyAllowed(true)
        ->setUsingCache(true)
        ->setRules($rules);
}

function afterInstall()
{
    updatePackages();
    $filesystem = new Filesystem();
    $filesystem->copy(__DIR__ . "/.php_cs", base_path('.php_cs'));
}

/**
 * Update the "package.json" file.
 *
 * @param  bool  $dev
 * @return void
 */
function updatePackages($dev = true)
{
    if (! file_exists(base_path('package.json'))) {
        return;
    }

    $configurationKey = $dev ? 'devDependencies' : 'dependencies';

    $packages = json_decode(file_get_contents(base_path('package.json')), true);

    $packages[$configurationKey] = array_merge(
        [
            'husky' => '^4.2.5',
            'lint-staged' => '^10.2.3',
        ],
        array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : []
    );

    ksort($packages[$configurationKey]);

    file_put_contents(
        base_path('package.json'),
        json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
    );
}
