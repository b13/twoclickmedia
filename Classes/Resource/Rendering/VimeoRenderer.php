<?php

declare(strict_types=1);

namespace B13\Twoclickmedia\Resource\Rendering;

/*
 * This file is part of TYPO3 CMS-based extension "twoclickmedia" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Core\Resource\FileInterface;

class VimeoRenderer extends \TYPO3\CMS\Core\Resource\Rendering\VimeoRenderer
{
    use TwoClickRendererTrait;

    public const templateName = 'Vimeo';
    public const type = 'vimeo';

    /**
     * @return int
     */
    public function getPriority()
    {
        return 50;
    }

    protected function createVideoUrl(array $options, FileInterface $file): string
    {
        return $this->createVimeoUrl($options, $file);
    }
}
