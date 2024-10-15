<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;

class FaqCard extends Component
{
    public $question;
    public $answer;

    public function mount($question, $answer) {
        $this->question = $question;
        $this->answer = $answer;
    }

    public function render()
    {
        return view('livewire.components.landing.faq-card');
    }
}
