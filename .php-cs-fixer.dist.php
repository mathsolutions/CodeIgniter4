<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use Nexus\CsConfig\Fixer\Comment\NoCodeSeparatorCommentFixer;
use Nexus\CsConfig\FixerGenerator;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->files()
    ->in([
        __DIR__ . '/system',
        __DIR__ . '/utils',
    ])
    ->exclude([
        'Pager/Views',
        'ThirdParty',
        'Validation/Views',
    ])
    ->notPath([
    ])
    ->notName('#Foobar.php$#')
    ->append([
        __FILE__,
        __DIR__ . '/.php-cs-fixer.no-header.php',
        __DIR__ . '/.php-cs-fixer.tests.php',
        __DIR__ . '/.php-cs-fixer.user-guide.php',
        __DIR__ . '/rector.php',
        __DIR__ . '/spark',
    ]);

$overrides = [
    // for updating to coding-standard
    'modernize_strpos' => true,
];

$options = [
    'cacheFile' => 'build/.php-cs-fixer.cache',
    'finder'    => $finder,
];

$config = Factory::create(new CodeIgniter4(), $overrides, $options)->forLibrary(
    'CodeIgniter 4 framework',
    'CodeIgniter Foundation',
    'admin@codeigniter.com'
);

$config
    ->registerCustomFixers(FixerGenerator::create('vendor/nexusphp/cs-config/src/Fixer', 'Nexus\\CsConfig\\Fixer'))
    ->setRules(array_merge($config->getRules(), [
        NoCodeSeparatorCommentFixer::name() => true,
    ]));

return $config;
