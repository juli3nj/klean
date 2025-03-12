<?php

namespace App\Fields;

use App\Fields\Partials\AcfReviews;
use App\Fields\Partials\AcfContact;
use App\Fields\Partials\AcfGallery;
use App\Fields\Partials\AcfPartenaires;
use App\Fields\Partials\AcfServices;
use App\Fields\Partials\AcfTextImg;
use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class AcfHome extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('acf_home');

        $fields
            ->setLocation('page', '==', get_page_by_path('accueil')->ID ?? '0');

        $fields
            ->addTab('hero', ['label' => 'Héro Scène'])
            ->addGroup('hero', ['label' => 'Hero Scène'])
            ->addText('title', ['label' => 'Titre'])
            ->addWysiwyg('subtitle', ['label' => 'Sous-titre'])
            ->addImage('image', ['label' => 'Image'])
            ->endGroup()
            ->addTab('section_1', ['label' => 'Présentation'])
            ->addGroup('section_1', ['label' => 'Présentation'])
            ->addPartial(AcfTextImg::class)
            ->endGroup()
            ->addTab('section_2', ['label' => 'Partenaires'])
            ->addGroup('section_2', ['label' => 'Partenaires'])
            ->addPartial(AcfPartenaires::class)
            ->endGroup()
            ->addTab('section_3', ['label' => 'Services'])
            ->addGroup('section_3', ['label' => 'Services'])
            ->addPartial(AcfServices::class)
            ->endGroup()
            ->addTab('section_4', ['label' => 'Galerie'])
            ->addGroup('section_4', ['label' => 'Galerie'])
            ->addPartial(AcfGallery::class)
            ->endGroup()
	        ->addTab('section_4_1', ['label' => 'Avis'])
            ->addGroup('section_4_1', ['label' => 'Avis'])
			->addPartial(AcfReviews::class)
			->endGroup()
			->addTab('section_5', ['label' => 'Contact'])
			->addGroup('section_5', ['label' => 'Contact'])
			->addPartial(AcfContact::class)
			->endGroup();


        return $fields->build();
    }
}
