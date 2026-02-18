<?php

declare(strict_types=1);

namespace B13\Twoclickmedia\Rendering;

/*
 * This file is part of TYPO3 CMS-based extension "twoclickmedia" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

class TwoClickTagRenderer
{
    protected array $extensionConfiguration;

    public function __construct(
        protected readonly ViewFactoryInterface $viewFactory,
    ) {
        $typoScriptSettings = $GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getSetupArray();
        $this->extensionConfiguration = $typoScriptSettings['plugin.']['tx_twoclickmedia.'];
    }

    public function shouldRender(): bool
    {
        return (bool)($this->extensionConfiguration['settings.']['mediaSecure'] ?? false);
    }

    public function render(
        FileInterface $file,
        string $src,
        string $attributes,
        mixed $width,
        mixed $height,
        string $type,
        string $templateName,
    ): string {
        $variables = [
            'file' => $file,
            'src' => $src,
            'type' => $type,
            'isReference' => $file instanceof FileReference,
            'dimensions' => ['width' => $width, 'height' => $height],
            'attributes' => $attributes,
        ];

        // calculate the padding for the item
        if (!empty($file->getProperty('height')) && !empty($file->getProperty('width'))) {
            $paddingTop = ((int)$file->getProperty('height') / (int)$file->getProperty('width')) * 100;
            $variables['paddingTop'] = $paddingTop;
        }

        $viewFactoryData = new ViewFactoryData(
            templateRootPaths: $this->extensionConfiguration['view.']['templateRootPaths.'],
            partialRootPaths: $this->extensionConfiguration['view.']['partialRootPaths.'],
            layoutRootPaths: $this->extensionConfiguration['view.']['layoutRootPaths.'],
            request: $GLOBALS['TYPO3_REQUEST'],
        );
        $view = $this->viewFactory->create($viewFactoryData);
        $view->assignMultiple($variables);
        return $view->render($templateName);
    }
}
