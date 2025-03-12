<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Socials extends Component
{
    /**
     * Socials links
     *
     * @var array
     */
    public ?Collection $socialsLinks = null;

    /**
     * FontAwesome Default Class for socials icons
     *
     * @var array
     */
    private array $defaultIcons = [
        'facebook' => 'fab fa-facebook-f',
        'x' => 'fab fa-twitter',
        'instagram' => 'fab fa-instagram',
        'linkedin' => 'fab fa-linkedin',
        'youtube' => 'fab fa-youtube',
        'pinterest' => 'fab fa-pinterest',
        'tiktok' => 'fab fa-tiktok',
        'google' => 'fab fa-google',
    ];

    /**
     * Icons Overwrite
     *
     * @var array|null
     */
    public ?array $icons;

    /**
     * Socials icons to render
     * [socialLink => iconClass]
     *
     * @var array
     */
    private ?array $renderSocials = [];

    /**
     * Icon Class
     *
     * @var string|null
     */
    public ?string $linkClass;

    /**
     * Container Class
     *
     * @var string|null
     */
    public ?string $containerClass;

    /**
     * Use BladeIcons ?
     */

    public bool $useBlade = false;

    /**
     * Create a new component instance.
     */
    public function __construct(?array $icons = [], ?string $linkClass = "", ?string $containerClass = "", ?bool $useBlade = false)
    {
        $this->useBlade         = $useBlade;
        $this->containerClass   = $containerClass;
        $this->linkClass        = $linkClass;
        $this->icons            = $icons;

        if (have_rows('social_medias', 'options')) {
            $this->socialsLinks = collect(get_field('social_medias', 'options'));

            $this->setSocialIcons();
        }
    }

    public function setSocialIcons(): void
    {
        foreach ($this->socialsLinks as $social) {
            $this->renderSocials[$social['media']]['link'] = $social['link'];
            if ($this->useBlade === true) {
                if(in_array($social['media'], $this->icons)){
                    $this->renderSocials[$social['media']]['type'] = 'blade';
                    $this->renderSocials[$social['media']]['icon'] =  $social['media'];
                }else{
                    $this->renderSocials[$social['media']]['type'] = 'icon';
                    $this->renderSocials[$social['media']]['icon'] = $this->defaultIcons[$social['media']];
                }
            } else {
                if ($social['media'] !== 'other') {
                    $this->renderSocials[$social['media']]['type'] = 'icon';
                    $this->renderSocials[$social['media']]['icon'] =  $this->defaultIcons[$social['media']];
                } else {
                    $this->renderSocials[$social['media']]['type'] = 'icon';
                    $this->renderSocials[$social['link']] = $social['other'];
                }
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.socials', [
            'socials' => $this->renderSocials,
            'containerClasses' => $this->containerClass,
            'iconClasses' => $this->linkClass,
        ]);
    }
}
