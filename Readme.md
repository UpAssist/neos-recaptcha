# UpAssist Neos reCaptcha

Provides a solution to use reCaptcha v3 in nodebased forms in Neos.

## Compatibility

| Version | Branch | Neos | Tested on | Composer |
| --- | --- | --- | --- | --- |
| 2.x | `main` | ^9.0 | 9.0, 9.1, 9.2 | `composer require upassist/neos-recaptcha:^2.0` |
| 1.x | `1.x` | ^8.3 | 8.3, 8.4 | `composer require upassist/neos-recaptcha:^1.2` |

## Install

```composer require upassist/neos-recaptcha```

## Configure

Add the mixin `UpAssist.Neos.ReCaptcha:Mixin.ReCaptchaConfiguration` to your homepage.

Make sure to register at https://www.google.com/recaptcha.

## Usage

Add a reCaptcha field to your form. The field is rendered by `neos/form-fusionrenderer`, so the form must use the
`fusion` preset (`presetName = 'fusion'`).
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
