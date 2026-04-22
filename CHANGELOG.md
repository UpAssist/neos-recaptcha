# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

## [2.0.0](https://github.com/UpAssist/neos-recaptcha/compare/1.2.1...2.0.0) (2026-04-21)

### ⚠ BREAKING CHANGES

* **Neos 9 support.** The 1.x line remains available on the `neos-8` branch for Neos 7/8.
* **PHP 8.2+** required.
* Finisher no longer reads `recaptchaSecret` from the site node via the legacy ContentContext API. The shipped Fusion passes `options.secret` from `q(site).property('recaptchaSecret')`. Sites that override `UpAssist.Neos.ReCaptcha:Finisher.ReCaptcha.Definition` in custom Fusion must add `options.secret`.
* `UpAssist\Neos\ReCaptcha\Service\ContentContextService` removed.

### Features

* drop legacy Neos 8 ContentContext dependency; finisher is now rendering-context-driven
* modernize to `declare(strict_types=1)` and typed `void` return

### [1.2.1](https://github.com/UpAssist/neos-recaptcha/compare/1.2.0...1.2.1) (2026-02-20)

## [1.2.0](https://github.com/UpAssist/neos-recaptcha/compare/1.1.0...1.2.0) (2026-02-20)


### Features

* **inclusion:** allow multiple forms with recaptcha validation ([3b54c15](https://github.com/UpAssist/neos-recaptcha/commit/3b54c15bedd1f5b9c58595001b3d8564cdc1972a))

## [1.1.0](https://github.com/UpAssist/neos-recaptcha/compare/1.0.3...1.1.0) (2026-02-16)


### Features

* **finisher:** added configurable threshold option ([6364e66](https://github.com/UpAssist/neos-recaptcha/commit/6364e664830a9d956863ad61e8a161a02bdd2568))

### [1.0.3](https://github.com/UpAssist/neos-recaptcha/compare/1.0.2...1.0.3) (2024-03-06)

### [1.0.2](https://github.com/UpAssist/neos-recaptcha/compare/1.0.1...1.0.2) (2024-03-06)


### Bug Fixes

* language labels are not translated ([37350bf](https://github.com/UpAssist/neos-recaptcha/commit/37350bfdd2fb73491be8e62cacaec2f5b630ca08))

## 1.0.0 (2024-03-06)
