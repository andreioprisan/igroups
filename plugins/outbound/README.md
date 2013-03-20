# Outbound Flows for OpenVBX

This plugin allows you to call out using flows, schedule calls and messages, or trigger outgoing calls or texts within another flow.

## Installation

[Download][1] the plugin and extract to /plugins

[1]: https://github.com/chadsmith/OpenVBX-Plugin-Outbound/archives/master

## Usage

Once installed, OUTBOUND will appear in the OpenVBX sidebar

### Call out with a Flow

1. Click Start Flow in the OpenVBX sidebar
2. Enter the number to call
3. Select the Flow to call with
4. Select the caller ID (OpenVBX number) to call with

### Schedule an outgoing call

1. Click Schedule Flow in the OpenVBX sidebar
2. Click Add Call
3. Enter the number to call
4. Enter the date and time to call
5. Select the Flow to call with
6. Select the caller ID (OpenVBX number) to call with

### Schedule a text message

1. Click Schedule Flow in the OpenVBX sidebar
2. Click Add SMS
3. Enter the number to call
4. Enter the date and time to call
5. Select the caller ID (OpenVBX number) to send with
6. Enter the message to text

### Trigger a call to another number from a Flow

1. Add the New Call applet to a Call or SMS flow
2. Select the caller ID (OpenVBX number) to call with
3. Select the Flow to call with
4. Enter the number to call

### Trigger an SMS to another number from a Flow

1. Add the New Text applet to a Call or SMS flow
2. Select the caller ID (OpenVBX number) to call with
3. Enter the number to text
3. Enter the message to text*

`* Use %caller% or %sender% to substitute the caller's number, %number% for the number called or %body% for the message body`

## Set Cron Job ##

A cron job must be set to send scheduled calls and messages every 5 minutes. If you have access to crontab, enter:

`*/5  * * * * /usr/bin/php5 /PATH_TO_OPENVBX/plugins/outbound/cron.php`

If using cron source or a poorman's cron use:

`http://YOUR_DOMAIN/hook/outbound/cron`
