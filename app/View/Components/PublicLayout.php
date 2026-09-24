<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null,
        public ?string $active = null,
        public ?string $socialInstagram = null,
        public ?string $socialWhatsapp = null,
        public ?string $socialYoutube = null,
    ) {
        $this->socialInstagram = $socialInstagram ?? Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $this->socialWhatsapp = $socialWhatsapp ?? Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $this->socialYoutube = $socialYoutube ?? Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.public', [
            'title' => $this->title,
            'active' => $this->active,
            'socialInstagram' => $this->socialInstagram,
            'socialWhatsapp' => $this->socialWhatsapp,
            'socialYoutube' => $this->socialYoutube,
        ]);
    }
}
