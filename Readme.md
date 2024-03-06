# UpAssist Neos reCaptcha

Provides a solution to use reCaptcha v3 in nodebased forms in Neos.

## Install

```composer require upassist/neos-recaptcha```

## Configure

Add the mixin `UpAssist.Neos.ReCaptcha:Mixin.ReCaptchaConfiguration` to your homepage.

Make sure to register at https://www.google.com/recaptcha.

## Usage

Add a reCaptcha field to your form.
Add the reCaptcha finisher as first finisher to your finishers. If the reCaptcha fails, the other finishers won't be
executed anymore.
