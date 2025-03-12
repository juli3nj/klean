<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Reviews extends Component
{
	public bool|string $title;
	public bool|string $subtitle;
	public bool|string $shortcode;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
		while (have_rows('section_4_1')) {
			the_row();
			$this->title = get_sub_field('title');
			$this->subtitle = get_sub_field('subtitle');
			$this->shortcode = get_sub_field('shortcode');
		}
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reviews');
    }
}
