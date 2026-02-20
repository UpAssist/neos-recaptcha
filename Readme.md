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
The finisher has a `threshold` option (default `0.5`) that you can change in the Neos inspector.

## Script Inclusion

The Google reCaptcha API script should be included once, just before `</body>`.

In projects with custom document/page prototypes, the safest approach is to add it to `body.javascripts` so it is
appended by your page template pipeline:

```fusion
prototype(Neos.Neos:Page) {
    body.javascripts.recaptchaApiScript = Neos.Fusion:Tag {
        @position = 'end 900'
        @if.hasSiteKey = ${q(site).property('recaptchaSiteKey')}
        tagName = 'script'
        attributes.src = ${'https://www.google.com/recaptcha/api.js?render=' + q(site).property('recaptchaSiteKey')}
    }
}
```

If your custom document prototypes redefine `body` or `body.javascripts`, make sure this script entry is also added in
those prototypes so it is not dropped by overriding.
