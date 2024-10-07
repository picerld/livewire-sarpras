<x-stat class="rounded-xl border bg-card text-card-foreground shadow text-black dark:text-slate-300/90 {{ $class }}"
    :title="$title"
    :value="$value"
    :icon="$icon"
    color="text-black"
    description="This month"
    tooltip="{{ $value > 10 ? 'Greater than 10' : 'Less than 10' }}" />
