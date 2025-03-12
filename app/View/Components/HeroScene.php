<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroScene extends Component
{
	public bool|string $title = '';

	public bool|string $subtitle = '';

	public bool|array $image = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if(have_rows('hero')){
	        while(have_rows('hero')){
		        the_row();

		        $this->title = get_sub_field('title');
		        $this->subtitle = get_sub_field('subtitle');
		        $this->image = get_sub_field('image');
	        }
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.hero-scene');
    }
}
