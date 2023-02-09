<?php
declare(strict_types=1);

/*
 * This file is part of the package bk2k/packagebuilder.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariablesExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        return [
            'template' => [
                'author' => [
                    'name' => 'Anatoli Sobolewski',
                    'email' => 'anatoli@ncn.de',
                    'hash' => md5('anatoli@ncn.de'),
                    'twitter' => 'anatolisobo90',
                    'github' => 'ans-ncn',
                    'description' => '',
                ]
            ]
        ];
    }

    public function getName(): string
    {
        return 'template_global_variable';
    }
}
