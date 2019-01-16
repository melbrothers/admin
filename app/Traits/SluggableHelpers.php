<?php
namespace App\Traits;

use Cocur\Slugify\Slugify;

trait SluggableHelpers {

    /**
     * @param Slugify $engine
     * @param string $attribute
     * @return Slugify
     */
    public function customizeSlugEngine(Slugify $engine, $attribute)
    {
        $engine->activateRuleSet('chinese');

        return $engine;
    }
}