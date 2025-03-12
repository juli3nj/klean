<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class AcfPartenaires extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $fields = Builder::make('acf_partenaires');

        $fields
            ->addText('title', [ 'label' => 'Titre'])
	        ->addWysiwyg('text', ['label' => 'Texte'])
	        ->addGallery('partenaires', ['label' => 'Logo partenaires']);

        return $fields;
    }
}
