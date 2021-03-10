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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class VimeoRenderer extends \TYPO3\CMS\Core\Resource\Rendering\VimeoRenderer
{
    const templateName = 'Iframe';

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
        $src = $this->createVimeoUrl($options, $file);
        $attributes = $this->collectIframeAttributes($width, $height, $options);

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManager::class);
        $extensionConfiguration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, 'Twoclickmedia');

        $iframeView = $objectManager->get(StandaloneView::class);
        $templateRootPath = GeneralUtility::getFileAbsFileName($extensionConfiguration['view']['templateRootPath']);
        $templatePathAndFilename = $templateRootPath . self::templateName . '.html';

        $variables = [
            'file' => $file,
            'src' => $src,
            'attributes' => empty($attributes) ? '' : ' ' . $this->implodeAttributes($attributes)
        ];
        $iframeView->setTemplatePathAndFilename($templatePathAndFilename);
        $iframeView->assignMultiple($variables);

        if ($extensionConfiguration['settings']['mediaSecure']) {
            return $iframeView->render();
        }

        return parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript);
    }
}
