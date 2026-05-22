<?php

namespace App\View\Components;

use Closure;

use Illuminate\View\View;

use Illuminate\View\Component;

/**
 * Main authenticated layout component.
 */
class AppLayout extends Component
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
        string $title = 'Vital Trackers'
    ) {

        $this->title = $title;
    }

    /**
     * Render layout component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.app');
    }
}