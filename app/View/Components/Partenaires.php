<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Partenaires extends Component
{
	public bool|string $title;

	public bool|string $text;

	public bool|array $gallery;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if(have_rows('section_2')){
			while(have_rows('section_2')){
				the_row();
				$this->title = get_sub_field('title');
				$this->text = get_sub_field('text');
				$this->gallery = get_sub_field('partenaires');
			}
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partenaires');
    }
}
