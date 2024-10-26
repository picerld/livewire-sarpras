<x-stat
    class="rounded-xl border bg-card text-card-foreground shadow text-black cursor-pointer dark:text-slate-300/90 hover:scale-[99%] transition-all duration-200"
    :title="$title" :value="$value" :icon="$icon" color="text-black" description="{{ $description }} total items"
    tooltip="{{ trim(explode('@', Auth::user()->username)[0]) }}'s Transaction" />
