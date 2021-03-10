# EXT:twoclickmedia - A TYPO3 Extension to add the possibility embed youtube / vimeo videos only via click of the fe user

## Feature

For backwardcompatibility reasons, this extension uses the b13/assetcollect to insert css in the head area of the page 
and js in the end of the body. In TYPO3 version 10 the native assetcollector of TYPO3 can be used.

## Installation

This feature can be activated via typoscript of the extension every youtube / vimeo video is processed

```
plugin.tx_twoclickmedia.settings.mediaSecure = 0
```
