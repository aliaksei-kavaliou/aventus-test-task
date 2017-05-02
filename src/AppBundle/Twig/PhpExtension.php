<?php

namespace AppBundle\Twig;

class PhpExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('chr', [$this, 'chrFilter']),
        ];
    }

    /**
     * Implement chr function fo twig
     * @param integer $value
     * @return string
     */
    public function chrFilter($value)
    {
        return chr($value);
    }
}