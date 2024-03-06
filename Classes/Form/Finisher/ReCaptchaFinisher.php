<?php

namespace UpAssist\Neos\ReCaptcha\Form\Finisher;

use Neos\ContentRepository\Domain\Repository\NodeDataRepository;
use Neos\ContentRepository\Exception\NodeException;
use Neos\Flow\Log\Exception;
use Neos\Form\Core\Model\AbstractFinisher;
use ReCaptcha\ReCaptcha;
use Neos\Flow\Annotations as Flow;
use UpAssist\Neos\ReCaptcha\Service\ContentContextService;

class ReCaptchaFinisher extends AbstractFinisher
{

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
        $secret = $this->parseOption('secret') ? $this->parseOption('secret') : $siteNode->getProperty('recaptchaSecret');

        if (empty($secret)) {
            throw new Exception('A secret is required');
        }

        $recaptcha = new ReCaptcha($secret);

        $resp = $recaptcha->verify($values['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            // Verified! Nothing to do
        } else {
//            $errors = $resp->getErrorCodes();
//            Todo: handle error codes?
            $this->finisherContext->cancel();
        }
    }
}
