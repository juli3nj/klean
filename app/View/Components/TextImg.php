<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextImg extends Component
{
	public bool|string $title = '';

	public bool|string $text = '';

	public bool|array $image = [];

	public bool|string $img_text = '';


    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        while(have_rows('section_1')){
			the_row();

			$this->title = get_sub_field('title');
			$this->text = get_sub_field('text');
			$this->image = get_sub_field('image');
			$this->img_text = get_sub_field('img_text');
		}
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.text-img');
    }
}
