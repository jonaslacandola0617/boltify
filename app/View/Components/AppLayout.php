<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $canonical = null,
        public bool $noindex = false,
        public ?string $image = null,
        public array $jsonLd = [],
    ) {
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
