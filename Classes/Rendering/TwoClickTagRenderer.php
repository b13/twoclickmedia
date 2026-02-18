<?php

declare(strict_types=1);

namespace B13\Twoclickmedia\Rendering;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

class TwoClickTagRenderer
{
    protected array $extensionConfiguration;

    public function __construct(
        ConfigurationManager $configurationManager,
        protected readonly ViewFactoryInterface $viewFactory,
    ) {
        $this->extensionConfiguration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, 'Twoclickmedia');
    }

    public function shouldRender(): bool
    {
        return (bool)($this->extensionConfiguration['settings']['mediaSecure'] ?? false);
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
            templateRootPaths: $this->extensionConfiguration['view']['templateRootPaths'],
            partialRootPaths: $this->extensionConfiguration['view']['partialRootPaths'],
            layoutRootPaths: $this->extensionConfiguration['view']['layoutRootPaths'],
            request: $GLOBALS['TYPO3_REQUEST'],
        );
        $view = $this->viewFactory->create($viewFactoryData);
        $view->assignMultiple($variables);
        return $view->render($templateName);
    }
}
