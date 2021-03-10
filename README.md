# EXT:twoclickmedia - A TYPO3 Extension to embed youtube / vimeo videos gdpr correct

## Feature

- Simple possibility to create gdpr ready youtube and vimeo videos
- Simply install, enable this feature and you are ready to go
- Adjustable template via fluid templates

## Installation

Install this extension via `composer req b13/twoclickmedia` or download it from the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/twoclickmedia/) and activate
the extension in the Extension Manager of your TYPO3 installation.

Now this feature can be enabled via typoscript:

```
plugin.tx_twoclickmedia.settings.mediaSecure = 1
```

## Template

Via layoutRootPaths, templaterootpaths or partialRootPaths the default layout, template or partial can be overwritten:
```
plugin.tx_twoclickmedia {
    view.layoutRootPaths.10 = EXT:twoclickmedia/Resources/Private/Layouts/
    view.templateRootPaths.10 = EXT:twoclickmedia/Resources/Private/Templates/
    view.partialRootPaths.10 = EXT:twoclickmedia/Resources/Private/Partials/
}
```
