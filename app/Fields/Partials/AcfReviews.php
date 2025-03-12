<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class AcfReviews extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $fields = Builder::make('acf_reviews');

        $fields
            ->addText('title', ['label' => 'Titre'])
            ->addText('subtitle', ['label' => 'Sous-titre'])
	        ->addText('shortcode', ['label' => 'Shortcode']);
        return $fields;
    }
}
