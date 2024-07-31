<?php

use Livewire\Volt\Component;

new #[Title('Login')] class extends Component {
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        if (auth()->user()) {
            return $this->redirectBasedOnRole(auth()->user());
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();

            return $this->redirectBasedOnRole(auth()->user());
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin');
            case 'pengawas':
                return redirect()->route('pengawas');
            case 'unit':
                return redirect()->route('unit');
            default:
                return redirect()->intended('/');
        }
    }
};
?>

<div class="mx-auto md:w-96">
    <div class="mb-8 hidden-when-collapsed">
        <div class="flex gap-1">
            {{-- <img src="{{ asset('img/logo.svg') }}" width="30" class="mt-1" width="200" height="50" alt="Sarpras"> --}}
            <svg class="inline text-primary w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5">
                </path>
            </svg>
            <span
                class="mr-3 text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-500 to-purple-300 bg-clip-text ">
                Sarpras
            </span>
        </div>
    </div>

    <x-form wire:submit="login" autoComplete="off">
        <x-input label="Email" wire:model="email" icon="o-envelope" class="text-slate-300" inline />
        <x-input label="Password" wire:model="password" type="password" class="text-slate-300" icon="o-key" inline />

        <x-slot:actions>
            <x-button label="Login" type="submit" icon="o-paper-airplane"
                class="btn-primary text-white/75 hover:opacity-90" spinner="login" />
        </x-slot:actions>
    </x-form>

    <div class="flex items-center justify-center mt-10">
        <x-button icon="o-code-bracket" label="Repository" class="text-base font-semibold btn-ghost text-slate-300"
        link="https://github.com/picerld/livewire-sarpras" external />
        <x-button icon="o-heart" label="Sarpras Team" class="text-base font-semibold btn-ghost text-secondary" />
    </div>
</div>
