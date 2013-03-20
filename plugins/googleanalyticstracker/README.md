# Google Analytics for OpenVBX

Track the current action of the flow in Google Analytics.

## Installation

[Download][1] the plugin and extract to /plugins

[1]: https://github.com/chadsmith/OpenVBX-Plugin-Analytics/archives/master

## Usage

1. Add the Track applet to your Call or SMS flow
2. Enter your Google Analytics account
3. Enter the URL to be tracked in Google Analytics*
4. (Optional) Enter the page title to appear in Google Analytics*

`* Use %caller% to substitute the caller or sender's number or %number% for the number called or texted`

**Sample setup**

Google Analytics account

`UA-XXXXX-X`

URL to track

`/%number%/voicemail`

Page title to track

`Voicemail from %caller% on %number%`

**Sample result**

This would track a pageview on Google Analytics account `UA-XXXXX-X` at the URL `/+15555551212/voicemail` with the title `Voicemail from +15555551313 on +15555551212`
