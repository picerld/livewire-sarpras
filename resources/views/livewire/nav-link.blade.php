<x-menu-item class="{{ $this->isActive() ? 'relative font-bold' : '' }}" icon="{{ $icon }}" link="{{ $link }}" no-wire-navigate>
    {{ $title }}
    <span class="{{ $this->isActive() ? 'absolute inset-y-0 left-0 w-1 rounded-tr-md rounded-br-md bg-primary' : 'hidden' }}" aria-hidden="true">
    </span>
</x-menu-item>