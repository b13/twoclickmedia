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
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class YouTubeRenderer extends \TYPO3\CMS\Core\Resource\Rendering\YouTubeRenderer
{
    const templateName = 'YouTube';
    const type = 'youtube';

    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    public function injectConfigurationManager(ConfigurationManager $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return 50;
    }

    /**
     * @param FileInterface $file
     * @param int|string $width
     * @param int|string $height
     * @param array $options
     * @param bool $usedPathsRelativeToCurrentScript
     * @param array $variables
     * @return string
     */
    public function render(
        FileInterface $file,
        $width,
        $height,
        array $options = [],
        $usedPathsRelativeToCurrentScript = false
    ) {
        $options = $this->collectOptions($options, $file);
        $src = $this->createYouTubeUrl($options, $file);
        $attributes = $this->collectIframeAttributes($width, $height, $options);

        $extensionConfiguration = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, 'Twoclickmedia');

        if (!($extensionConfiguration['settings']['mediaSecure'] ?? false)) {
            return parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript);
        }

        $variables = [
            'file' => $file,
            'src' => $src,
            'type' => self::type,
            'isReference' => $file instanceof FileReference,
            'dimensions' => ['width' => $width, 'height' => $height],
            'attributes' => empty($attributes) ? '' : ' ' . $this->implodeAttributes($attributes)
        ];

        // calculate the padding for the item
        if (!empty($file->getProperty('height')) && !empty($file->getProperty('width'))) {
            $paddingTop = ($file->getProperty('height') / $file->getProperty('width')) * 100;
            $variables['paddingTop'] = $paddingTop;
        }

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths($extensionConfiguration['view']['layoutRootPaths']);
        $view->setPartialRootPaths($extensionConfiguration['view']['partialRootPaths']);
        $view->setTemplateRootPaths($extensionConfiguration['view']['templateRootPaths']);
        $view->setTemplate(self::templateName);
        $view->assignMultiple($variables);
        $view->setRequest($GLOBALS['TYPO3_REQUEST']);

        return $view->render();
    }
}
