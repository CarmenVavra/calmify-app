{{-- Labelled checkbox with accessible error message. The slot is the label. --}}
@props(['name', 'checked' => false, 'bag' => 'default'])

@php
    $id = 'field-'.$name;
    $error = $errors->getBag($bag)->first($name);
@endphp

<div class="flex flex-col gap-2">
    <div @class([
        'flex items-start gap-3.5 rounded-[18px] border-[1.5px] bg-calm-surface px-4 py-4',
        'border-calm-sos' => $error,
        'border-transparent' => ! $error,
    ])>
        <input id="{{ $id }}"
               name="{{ $name }}"
               type="checkbox"
               value="1"
               @checked(old($name, $checked))
               @if ($error) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
               {{ $attributes->class('mt-0.5 h-6 w-6 shrink-0 cursor-pointer accent-calm-accent focus-visible:outline-offset-2') }}>
        <label for="{{ $id }}" class="cursor-pointer text-[16px] leading-[1.45] text-calm-text">{{ $slot }}</label>
    </div>

    @if ($error)
        <p id="{{ $id }}-error" class="px-1 text-[15px] leading-[1.45] text-calm-sos">{{ $error }}</p>
    @endif
</div>
