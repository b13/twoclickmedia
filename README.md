# EXT:twoclickmedia - Two click solution to include YouTube / Vimeo videos

This extension replaces TYPO3's default YouTube/VimeoRenderer with a two click solution, showing a preview/teaser first
and adding the iFrame connecting to YouTube or Vimeo once a user clicks on the preview image. It does not set or read
any cookies and does not save a user's default state (there is no &quot;show me all YouTube videos on this site&quot;
setting).

This extension comes with a default template for the preview image as well as a default JS to insert the iFrame normally
used for displaying YouTube or Vimeo content.

## Installation

Install this extension via `composer req b13/twoclickmedia` or download it from the
[TYPO3 Extension Repository](https://extensions.typo3.org/extension/twoclickmedia/) and activate
the extension in the Extension Manager of your TYPO3 installation.

Add ``b13/twoclickmedia`` as dependency to your Site Set (v13)
Or (for v12) include this extensions' TypoScript settings by adding the default settings to your TypoScript setup:

```
@import 'EXT:twoclickmedia/Configuration/Sets/Twoclickmedia/setup.typoscript'
```

## Template

If you need to change the default template provided by this extension, add your own Fluid paths to the configuration:

```
plugin.tx_twoclickmedia {
    view.layoutRootPaths.100 = EXT:my_extension/Resources/Private/Plugins/Twocklickmedia/Layouts/
    view.templateRootPaths.100 = EXT:my_extension/Resources/Private/Plugins/Twocklickmedia/Templates/
    view.partialRootPaths.100 = EXT:my_extension/Resources/Private/Plugins/Twocklickmedia/Partials/
}
```

## Credits

This extension was created by Daniel Gorges in 2021 for [b13 GmbH, Stuttgart](https://b13.com).

[Find more TYPO3 extensions we have developed](https://b13.com/useful-typo3-extensions-from-b13-to-you) that help us
deliver value in client projects. As part of the way we work, we focus on testing and best practices to ensure
long-term performance, reliability, and results in all our code.
