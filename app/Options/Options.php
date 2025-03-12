<?php

namespace App\Options;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Options as Field;

class Options extends Field
{
    /**
     * The option page menu name.
     *
     * @var string
     */
    public $name = 'Options';

    /**
     * The option page document title.
     *
     * @var string
     */
    public $title = 'Options du thème';

    /**
     * The option page field group.
     */
    public function fields(): array
    {
        $socials = Builder::make('socials');

        $socials
            ->addRepeater('social_medias')
            ->addSelect('media', [
                'label' => __('Réseau', 'sage'),
                'choices' => [
                    'facebook' => 'Facebook',
                    'instagram' => 'Instagram',
                    'linkedin' => 'Linkedin',
                    'x' => 'X / Twitter',
                    'youtube' => 'Youtube',
                    'tiktok' => 'TikTok',
                    'pinterest' => 'Pinterest',
                    'other' => 'Autre',
                ],
            ])->addText('other', [
                'label' => __('Classe FontAwesome', 'sage'),
                'conditional_logic' => [
                    [
                        'field' => 'media',
                        'operator' => '==',
                        'value' => 'other',
                    ],
                ],
            ])->addText('link', [
                'label' => __('Lien', 'sage'),
            ])
            ->endRepeater()
            ->addText('phone', [
                'label' => __('Téléphone', 'sage'),
            ])
            ->addText('fax', [
                'label' => __('Fax', 'sage'),
            ])
            ->addText('email', [
                'label' => __('Email', 'sage'),
            ])
            ->addGroup('contact_address')
            ->addText('company', [
                'label' => __('Nom', 'sage'),
            ])
            ->addText('address', [
                'label' => __('Adresse', 'sage'),
            ])
            ->addText('postal_code', [
                'label' => __('Code Postal', 'sage'),
            ])
            ->addText('city', [
                'label' => __('Ville', 'sage'),
            ])
            ->addText('country', [
                'label' => __('Pays', 'sage'),
            ])
            ->endGroup()
            ->addLink('client_link', [
                'label' => __('Lien Acces Client', 'sage'),
            ])
            ->addText('catalan_link', [
                'label' => __('Lien drapeau Catalan', 'sage'),
            ]);

        return $socials->build();
    }
}
