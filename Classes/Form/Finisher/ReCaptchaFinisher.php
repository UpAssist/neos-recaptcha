<?php
declare(strict_types=1);

namespace UpAssist\Neos\ReCaptcha\Form\Finisher;

use Neos\Form\Core\Model\AbstractFinisher;
use Neos\Form\Exception\FinisherException;
use ReCaptcha\ReCaptcha;

class ReCaptchaFinisher extends AbstractFinisher
{
    private const DEFAULT_THRESHOLD = 0.5;
    private const DEFAULT_FIELD_NAME = 'g-recaptcha-response';

    protected $defaultOptions = [
        'fieldName' => self::DEFAULT_FIELD_NAME,
        'threshold' => self::DEFAULT_THRESHOLD,
    ];

    protected function executeInternal(): void
    {
        $secret = (string)$this->parseOption('secret');
        if ($secret === '') {
            throw new FinisherException(
                'ReCaptchaFinisher requires a "secret" option. Pass it via Fusion from q(site).property("recaptchaSecret").',
                1713700000
            );
        }

        $fieldName = (string)$this->parseOption('fieldName');
        $threshold = (float)$this->parseOption('threshold');
        $formRuntime = $this->finisherContext->getFormRuntime();
        $token = (string)($formRuntime[$fieldName] ?? '');

        $recaptcha = (new ReCaptcha($secret))->setScoreThreshold($threshold);
        $response = $recaptcha->verify($token, $_SERVER['REMOTE_ADDR'] ?? null);

        if (!$response->isSuccess()) {
            $this->finisherContext->cancel();
        }
    }
}
