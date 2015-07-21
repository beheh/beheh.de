<?php

namespace BehEh\Adapter;

use Aptoma\Twig\Extension\MarkdownEngineInterface;
use ParsedownExtra;

/**
 * 
 *
 * Maps Parsedown to Aptoma\Twig Markdown Extension
 *
 * @author Benedict Etzel <developer@beheh.de>
 */
class ParsedownExtraEngine implements MarkdownEngineInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform($content)
    {
        return ParsedownExtra::instance()->text($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'erusev\parsedown-extra';
    }
}
