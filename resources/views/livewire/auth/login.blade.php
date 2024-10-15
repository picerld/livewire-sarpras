<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Login')] class extends Component {
    use Toast;
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
            default:
                return $this->success('Login success!', 'Success!', redirectTo: route('unit'), position: 'toast-bottom');
        }
    }
};
?>

<div class="flex flex-col w-full h-screen md:flex-row">
    <!-- Left Section -->
    <div class="hidden w-full h-screen text-white bg-black/90 md:flex md:w-1/2 md:flex-col">
        <a href="/" class="flex gap-3 p-8">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6">
                <rect width="256" height="256" fill="none"></rect>
                <line x1="208" y1="128" x2="128" y2="208" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                <line x1="192" y1="40" x2="40" y2="192" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
            </svg>
            <h4 class="text-lg font-semibold">Sarpras</h4>
        </a>

        <div class="flex items-end flex-grow p-8">
            <div>
                <p class="mb-4 text-lg italic">"Sarana Prasarana SMKN 11 Bandung."</p>
                <p class="font-semibold">Pa Toni</p>
            </div>
        </div>
    </div>

    <!-- Right Section -->
    <div class="flex flex-col items-center justify-center w-full h-screen p-8 bg-white md:w-1/2">
        <div class="w-full max-w-md">
            <!-- Form title -->
            <div class="flex flex-col items-center">
                <h2 class="mb-4 text-3xl font-semibold text-gray-800">Login to Sarpras</h2>
                <p class="mb-8 text-gray-600">Enter your email below to login to your account.</p>
            </div>

            <x-form wire:submit.prevent="login" no-separator>
                <div>
                    <x-input wire:model="username" id="username" type="email" placeholder="name@example.com"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-dark focus:border-dark focus:outline-none" />
                </div>
                <div>
                    <x-input wire:model="password" id="password" type="password" placeholder="*******"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-dark focus:border-dark focus:outline-none" />
                </div>

                <x-slot:actions>
                    <x-button type="submit" spinner="login"
                        class="w-full font-medium text-white bg-black rounded-lg shadow-md hover:bg-gray-800">
                        Sign in with Email
                    </x-button>
                </x-slot:actions>
            </x-form>

            {{-- <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 text-gray-500 bg-white">OR CONTINUE WITH</span>
                </div>
            </div>

            <x-button
                class="flex items-center justify-center w-full py-2 space-x-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                <span>GitHub</span>
            </x-button> --}}
        </div>
    </div>
</div>
