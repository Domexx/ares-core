<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Service;

use Ares\Framework\Model\Locale;

/**
 * Class LocaleService
 *
 * @package Ares\Framework\Service
 */
class LocaleService
{
    /**
     * LocaleService constructor.
     *
     * @param Locale $locale
     */
    public function __construct(
        private readonly Locale $locale
    ) {}

    /**
     * Takes message and placeholder to translate them in given locale.
     *
     * @param string $key
     * @param array  $placeholder
     * @return string
     */
    public function translate(string $key, array $placeholder = []): string
    {
        $message = $this->locale->translate($key);

        if (!$placeholder) {
            return $message;
        }

        return vsprintf($message, $placeholder);
    }
}
