<?php

// https://laravel-news.com/sharing-php-cs-fixer-rules-across-projects-and-teams

$project_path = getcwd();
$finder = PhpCsFixer\Finder::create()
    ->in([
        $project_path . '/app',
        $project_path . '/config',
        $project_path . '/database',
        $project_path . '/resources',
        $project_path . '/routes',
        $project_path . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return Yuca\styles($finder);
