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

use B13\Twoclickmedia\Rendering\TwoClickTagRenderer;
use TYPO3\CMS\Core\Resource\FileInterface;

class YouTubeRenderer extends \TYPO3\CMS\Core\Resource\Rendering\YouTubeRenderer
{
    public const templateName = 'YouTube';
    public const type = 'youtube';

    public function __construct(
        protected TwoClickTagRenderer $tagRenderer
    ) {}

    /**
     * @return int
     */
    public function getPriority()
    {
        return 50;
    }

    public function render(FileInterface $file, $width, $height, array $options = [])
    {
        if (!$this->tagRenderer->shouldRender()) {
            return parent::render($file, $width, $height, $options);
        }
        $options = $this->collectOptions($options, $file);
        $attributes = $this->collectIframeAttributes($width, $height, $options);
        return $this->tagRenderer->render(
            file: $file,
            src: $this->createYouTubeUrl($options, $file),
            attributes: empty($attributes) ? '' : ' ' . $this->implodeAttributes($attributes),
            width: $width,
            height: $height,
            type: self::type,
            templateName: self::templateName,
        );
    }
}
