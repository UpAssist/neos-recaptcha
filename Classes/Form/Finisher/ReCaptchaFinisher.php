<?php

namespace UpAssist\Neos\ReCaptcha\Form\Finisher;

use Neos\ContentRepository\Exception\NodeException;
use Neos\Flow\Log\Exception;
use Neos\Form\Core\Model\AbstractFinisher;
use ReCaptcha\ReCaptcha;
use Neos\Flow\Annotations as Flow;
use UpAssist\Neos\ReCaptcha\Service\ContentContextService;

class ReCaptchaFinisher extends AbstractFinisher
{
    protected const DEFAULT_THRESHOLD = 0.5;

    /**
     * @var ContentContextService $contentContextService
     * @Flow\Inject
     */
    protected ContentContextService $contentContextService;

    /**
     * @inheritDoc
     * @throws NodeException
     */
    protected function executeInternal()
    {
        $siteNode = $this->contentContextService->getContentContext()->getCurrentSiteNode();
        $values = $this->finisherContext->getFormValues();
        $formRenderables = $this->finisherContext->getFormRuntime()->getFormDefinition()->getRenderablesRecursively();
        $recaptchaField = current(array_filter($formRenderables, function($renderable) {
            return $renderable->getType() === 'UpAssist.Neos.ReCaptcha:Field.ReCaptcha';
        }));
        $secret = $siteNode->getProperty('recaptchaSecret');
        $thresholdOption = $this->parseOption('threshold');
        $threshold = is_numeric($thresholdOption) ? (float)$thresholdOption : self::DEFAULT_THRESHOLD;

        if (empty($recaptchaField) || empty($recaptchaField->getIdentifier())) {
            throw new Exception('A recaptcha field is required');
        }

        if (empty($secret)) {
            throw new Exception('A secret is required');
        }

        $recaptcha = (new ReCaptcha($secret))->setScoreThreshold($threshold);

        $resp = $recaptcha->verify($values[$recaptchaField->getIdentifier()], $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            // Verified! Nothing to do
        } else {
//            $errors = $resp->getErrorCodes();
//            Todo: handle error codes?
            $this->finisherContext->cancel();
        }
    }
}
