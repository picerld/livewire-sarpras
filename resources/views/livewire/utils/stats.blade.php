<x-stat class="rounded-xl border bg-card text-card-foreground shadow text-black cursor-pointer dark:text-slate-300/90 {{ $class }}"
    :title="$title"
    :value="$value"
    :icon="$icon"
    color="text-black"
    description="{{ now()->format('Y') }}'s"
    tooltip="{{ now()->format('Y') }}'s Transaction " />
