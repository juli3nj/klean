<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class AcfContact extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $fields = Builder::make('acf_contact');

        $fields
            ->addText('title', ['label' => 'Titre'])
            ->addWysiwyg('description', ['label' => 'Description'])
	        ->addText('shortcode', ['label' => 'Shortcode']);

        return $fields;
    }
}
