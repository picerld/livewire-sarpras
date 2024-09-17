<?php

use Livewire\Volt\Component;

new #[Title('Login')] class extends Component {
    #[Rule('required|email')]
    public string $username = '';

    #[Rule('required')]
    public string $password = '';

    protected array $rules = [
        'username' => 'required',
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
        $this->addError('password', 'The provided credentials do not match our records.');
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
        <div class="flex flex-col items-center gap-2">
            <img src="{{ asset('img/login.png') }}" class="mt-1" width="200" height="200" alt="Sarpras">
            {{-- <svg class="inline text-white w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5">
                </path>
            </svg> --}}
            {{-- <span
                class="mr-3 text-3xl font-bold text-transparent bg-gradient-to-r from-white to-slate-400 bg-clip-text ">
                Sarpras
            </span>
        </div> --}}
        </div>

        <x-form wire:submit="login" no-separator>
            <x-input label="Username" wire:model="username" icon="o-envelope" placeholder="me@example.com"
                class="text-white border-white outline-none focus:border-white active:border-white focus:outline-none active:outline-none bg-base-300" />
            <x-input label="Password" wire:model="password" type="password"
                class="text-white border-white outline-none focus:border-white active:border-white focus:outline-none active:outline-none bg-base-300"
                icon="o-key" placeholder="******" />

            <x-slot:actions>
                <x-button label="Login" type="submit" icon="o-paper-airplane"
                    class="bg-accent hover:bg-accent hover:opacity-90 text-white/95" spinner="login" />
            </x-slot:actions>
        </x-form>

        <div class="flex items-center justify-center mt-10">
            <x-button icon="o-code-bracket" label="Repository" class="text-sm font-semibold btn-ghost text-slate-300"
                link="https://github.com/picerld/livewire-sarpras" external />
            <x-button icon="o-heart" label="Sarpras Team" class="text-sm font-semibold btn-ghost text-primary" />
        </div>
</div>