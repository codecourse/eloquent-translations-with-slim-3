<?php

namespace App\Views\Extensions;

use Illuminate\Translation\Translator;
use Twig_Extension;
use Twig_SimpleFunction;

class TranslationExtension extends Twig_Extension
{
    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('trans', [$this, 'trans']),
            new Twig_SimpleFunction('trans_choice', [$this, 'transChoice']),
            new Twig_SimpleFunction('locale', [$this, 'locale'])
        ];
    }

    public function trans($key, array $replace = [])
    {
        return $this->translator->trans($key, $replace);
    }

    public function transChoice($key, $count, array $replace = [])
    {
        return $this->translator->transChoice($key, $count, $replace);
    }

    public function locale()
    {
        return $this->translator->getLocale();
    }
}