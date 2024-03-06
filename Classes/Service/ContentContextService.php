<?php
namespace UpAssist\Neos\ReCaptcha\Service;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Domain\Repository\DomainRepository;
use Neos\Neos\Domain\Repository\SiteRepository;
use Neos\Neos\Domain\Service\ContentContext;
use Neos\Neos\Domain\Service\ContentContextFactory;

/**
 * @Flow\Scope("singleton")
 */
class ContentContextService
{

    /**
     * @var ContentContext
     */
    protected ContentContext $contentContext;

    /**
     * @Flow\Inject
     * @var ContentContextFactory
     */
    protected ContentContextFactory $contentContextFactory;

    /**
     * @Flow\Inject
     * @var DomainRepository
     */
    protected DomainRepository $domainRepository;

    /**
     * @Flow\Inject
     * @var SiteRepository
     */
    protected SiteRepository $siteRepository;

    /**
     * @param array $contextProperties
     * @return ContentContext
     */
    public function getContentContext(array $contextProperties = []): ContentContext
    {

        $contextPropertiesArray = ['workspaceName' => 'live'];
        $contextProperties = \Neos\Utility\Arrays::arrayMergeRecursiveOverrule($contextPropertiesArray, $contextProperties);

        $currentDomain = $this->domainRepository->findOneByActiveRequest();

        if ($currentDomain !== NULL) {
            $contextProperties['currentSite'] = $currentDomain->getSite();
            $contextProperties['currentDomain'] = $currentDomain;
        } else {
            $contextProperties['currentSite'] = $this->siteRepository->findFirstOnline();
        }

        return $this->contentContextFactory->create($contextProperties);
    }

}
