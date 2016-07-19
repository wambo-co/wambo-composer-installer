# Wambo Composer Installer

A composer plugin to install wambo modules to a wambo project.

[![Build Status](https://travis-ci.org/wambo-co/wambo-composer-installer.svg)](https://travis-ci.org/wambo-co/wambo-composer-installer)
[![Total Downloads](https://poser.pugx.org/wambo/wambo-composer-installer/d/total.svg)](https://packagist.org/packages/wambo/wambo-composer-installer)
[![Latest Stable Version](https://poser.pugx.org/wambo/wambo-composer-installer/v/stable.svg)](https://packagist.org/packages/wambo/wambo-composer-installer)
[![Latest Unstable Version](https://poser.pugx.org/wambo/wambo-composer-installer/v/unstable.svg)](https://packagist.org/packages/wambo/wambo-composer-installer)
[![License](https://poser.pugx.org/wambo/wambo-composer-installer/license.svg)](https://packagist.org/packages/wambo/wambo-composer-installer)


## Installation

```bash
composer require wambo/wambo-composer-installer
```

## Usage

to install a module to a wambo project you can use a this installer. The installer get "extra -> class" from
composer.json and add them a json file: `vendor/modules.json`.

```json
{
  "type": "wambo-module",
}
```

```json
  "extra": {
    "class": "Wambo\\Test\\Test"
  },
  "autoload": {
    "psr-4": {
      "Wambo\\Test\\": "src/Wambo/Test/"
    }
  },
```