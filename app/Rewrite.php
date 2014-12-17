<?php

namespace UltraPress;

use Data;
use UltraPress\PostTypes\PostType;

/**
 * Class for easilty registering rewrite rules for a
 * custom post type, without having to type an regex.
 */
class Rewrite
{

    /**
     * The array of regex => query pairs.
     *
     * @var array
     */
    private $rules = [];

    /**
     * The post type the rules are for.
     *
     * @var UltraPress\PostTypes\PostType
     */
    private $postType;

    /**
     * Generate some new rewrite rules for a post type.
     *
     * @param PostType $postType
     * @param array $rules An array of rewrite rules
     */
    public function __construct(PostType $postType, array $rules)
    {
        $this->postType = $postType;

        foreach($this->getRulesets($rules) as $ruleset)
        {
            $rulePair = $this->generateRule($ruleset);

            $this->rules[$rulePair[0]] = $rulePair[1];
        }

        $this->addRewriteRules();
    }

    /**
     * Split rules into chunks: one for each url section.
     *
     * @param array $rules Rules passed to instance
     * @return array $rulesets Split rules
     */
    private function getRulesets($rules)
    {
        $rulesets = [];

        foreach($rules as $rule)
        {
            $rulesets[] = explode('/', $rule);
        }

        return $rulesets;
    }

    /**
     * Generate a rule for an array that Wordpress can understand.
     *
     * @param array $ruleset The chunks for the rule
     * @return array regex => query rule pair for Wordpress
     */
    private function generateRule($ruleset)
    {
        $regex = '';
        $content = 'index.php';

        $count = 0;
        $total = count($ruleset);

        foreach($ruleset as $ruleChunk)
        {
            $count++;

            if(preg_match('/\{\w+\}/', $ruleChunk))
            {
                // Add to the url catcher
                $regex .= '/([^/]+)';

                // Add to the query string
                $string = preg_match('/\{(.*?)\}/', $ruleChunk, $matches);

                if($count === 1)
                {
                    $content .= '?' . $matches[1];
                }
                else
                {
                    $content .= '&' . $matches[1];
                }

                Data::dump($content);
            }
            else
            {
                // Add to the url catcher
                $regex .= '/' . $ruleChunk;
            }
        }

        $regex .= '/?$';

        return array($regex, $content);
    }

    /**
     * Register a rewrite rule with Wordpress.
     */
    private function addRewriteRules()
    {
        foreach($this->rules as $key => $value)
        {
            add_rewrite_rule($key, $value, 'top');
        }
    }

}
