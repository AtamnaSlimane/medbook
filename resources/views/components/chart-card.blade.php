<div>
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->

@props(['title', 'icon', 'iconColor'])

<div class="bg-slate-800 rounded-2xl p-5 shadow-sm">
    <h4 class="text-sm text-gray-300 mb-3 flex items-center gap-2 font-medium">
        <i class="fas fa-{{ $icon }} {{ $iconColor }}"></i>
        {{ $title }}
    </h4>
    <div class="w-full max-w-full mx-auto">
        {{ $slot }}
    </div>
</div>
</div>
