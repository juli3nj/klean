<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class AcfGallery extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $fields = Builder::make('acf_gallery');

        $fields
            ->addText('title', ['label' => 'Titre'])
	        ->addWysiwyg('description', ['label' => 'Description'])
	        ->addGallery('gallery', ['label' => 'Galerie']);

        return $fields;
    }
}
