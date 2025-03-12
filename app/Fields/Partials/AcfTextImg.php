<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class AcfTextImg extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $fields = Builder::make('acf_text_img');

        $fields
            ->addText('title', ['label' => 'Titre'])
	        ->addWysiwyg('text', ['label' => 'Texte'])
	        ->addImage('image', ['label' => 'Image'])
	        ->addText('img_text', ['label' => 'Texte de l\'image']);

        return $fields;
    }
}
