# GoIP SMS interface API

This package implements an SMS interface for GoIP devices and exposes it as an
API. It includes methods to handling devices and sms communication at a
low-level and high-level alike.

## Features

* Low-level GoIP client and SMS handler.
* High-level GoIP *Remote Administration* handler, linked to v1.08.
* High-level SMS gateway for sending and receiving SMS.

## Installation

### Composer

Add the repository manually and require the dependency in *composer.json*.

```json
{
    "repositories": [{
        "type": "vcs",
        "url": "https://github.com/julianmejio/goip-php-api.git"
    }],
    "require": {
        "aprilsacil/goip-php-api": "*"
    }
}
```

## Known bugs

* The year of the date in SMS messages is hardcoded to the current year, because
  the GoIP API doesn't store that data, only the month, the day and the hour.
* The method `\GoIP\Sms\SmsGateway::sendSmsAndWaitResponse()` only can handle
  one response per line simultaneously. If two o more SMS are sent through the
  line at the same time, it will break the response functionality due race
  conditions.

## Next features

I forked this project because I needed an API that can handle *Remote
Adminsitration* servers. I don't have the intention to adding new features until
I really need them.

I consider this fork as a high-impact to its parent, regardless the backwards
compatibility in its low-level API. Because of this, I didn't PR it.
