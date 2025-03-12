<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Services extends Component
{
	public bool|string $title = '';
	public bool|string $description ='';
	public bool|array $services = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
		if(have_rows('section_3')){
			while(have_rows('section_3')){
				the_row();
				$this->title = get_sub_field('title');
				$this->description = get_sub_field('description');
				$this->services = get_sub_field('services');
			}
		}
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.services');
    }
}
