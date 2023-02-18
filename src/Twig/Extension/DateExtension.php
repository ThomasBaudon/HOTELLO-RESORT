<?php
namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('tomorrow', [$this, 'tomorrow']),
        ];
    }

    public function tomorrow()
    {
        return new \DateTimeImmutable('+1 day');
    }
}