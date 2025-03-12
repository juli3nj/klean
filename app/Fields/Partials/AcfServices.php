<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class AcfServices extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $fields = Builder::make('acf_services');

        $fields
	        ->addText('title', ['label' => 'Titre'])
	        ->addText('description', ['label' => 'Description'])
	        ->addRepeater('services', ['label' => 'Services'])
	            ->addImage('icon', ['label' => 'Icone'])
	            ->addText('title', ['label' => 'Titre Service'])
	            ->addWysiwyg('description', ['label' => 'Description Service'])
	        ->endRepeater();

        return $fields;
    }
}
