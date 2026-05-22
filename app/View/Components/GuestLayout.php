<?php

namespace App\View\Components;

use Closure;

use Illuminate\View\View;

use Illuminate\View\Component;

/**
 * Guest authentication layout component.
 */
class GuestLayout extends Component
{
    /**
     * Page title.
     *
     * @var string
     */
    public string $title;

    /**
     * Create component instance.
     */
    public function __construct(
        string $title = 'Authentication'
    ) {

        $this->title = $title;
    }

    /**
     * Render guest layout.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.guest');
    }
}