<?php

namespace App\View\Components\Features;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filter extends Component
{
    public array $categories = [];

    /**
     * Create a new component instance.
     */
    public function __construct($categories = [])
    {
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.features.filter');
    }
}
