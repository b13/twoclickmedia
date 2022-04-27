<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        $rendererRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::class);
        $rendererRegistry->registerRendererClass(\B13\Twoclickmedia\Resource\Rendering\YouTubeRenderer::class);
        $rendererRegistry->registerRendererClass(\B13\Twoclickmedia\Resource\Rendering\VimeoRenderer::class);
    }
);
