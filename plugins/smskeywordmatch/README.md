# Advanced SMS matching for OpenVBX

Similar to the Menu applet, except you can respond to an SMS keyword with an entire flow instead of a single message.

## Installation

[Download][1] the plugin and extract to /plugins

[1]: https://github.com/chadsmith/OpenVBX-Plugin-Match/archives/master

## Usage (Basic)

1. Add the Match applet to your SMS flow
2. Enter one or more keywords to match (case insensitive) and an applet for each keyword
3. (Optional) Enter a default applet in case none of the keywords match

## Usage (Advanced)

1. Add the RegEx applet to your SMS flow
2. Enter one or more regular expressions to match (case insensitive) and an applet for each match
3. (Optional) Enter a default applet in case none of the keywords match

Example RegEx:

	^(join|subscribe|enroll|start)

Would match messages that begin with join, subscribe, enroll or start.
