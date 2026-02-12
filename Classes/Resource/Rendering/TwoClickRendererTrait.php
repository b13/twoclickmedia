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

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

#[Autoconfigure(public: true)]
trait TwoClickRendererTrait
{
    public function __construct(
        protected readonly ConfigurationManager $configurationManager,
        protected readonly ViewFactoryInterface $viewFactory,
    ) {}

    public function render(
        FileInterface $file,
        $width,
        $height,
        array $options = []
    ) {
        $options = $this->collectOptions($options, $file);
        $src = $this->createVideoUrl($options, $file);
        $attributes = $this->collectIframeAttributes($width, $height, $options);

        $extensionConfiguration = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, 'Twoclickmedia');

        if (!($extensionConfiguration['settings']['mediaSecure'] ?? false)) {
            return parent::render($file, $width, $height, $options);
        }

        $variables = [
            'file' => $file,
            'src' => $src,
            'type' => self::type,
            'isReference' => $file instanceof FileReference,
            'dimensions' => ['width' => $width, 'height' => $height],
            'attributes' => empty($attributes) ? '' : ' ' . $this->implodeAttributes($attributes),
        ];

        // calculate the padding for the item
        if (!empty($file->getProperty('height')) && !empty($file->getProperty('width'))) {
            $paddingTop = ((int)$file->getProperty('height') / (int)$file->getProperty('width')) * 100;
            $variables['paddingTop'] = $paddingTop;
        }

        $viewFactoryData = new ViewFactoryData(
            templateRootPaths: $extensionConfiguration['view']['templateRootPaths'],
            partialRootPaths: $extensionConfiguration['view']['partialRootPaths'],
            layoutRootPaths: $extensionConfiguration['view']['layoutRootPaths'],
            request: $GLOBALS['TYPO3_REQUEST'],
        );
        $view = $this->viewFactory->create($viewFactoryData);
        $view->assignMultiple($variables);
        return $view->render(self::templateName);
    }

    abstract protected function createVideoUrl(array $options, FileInterface $file): string;
}
