{{-- Labelled text input with hint and accessible error message. --}}
@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null, 'bag' => 'default'])

@php
    $id = 'field-'.$name;
    $error = $errors->getBag($bag)->first($name);
    $describedBy = collect([$hint ? $id.'-hint' : null, $error ? $id.'-error' : null])->filter()->implode(' ');
@endphp

<div class="flex flex-col gap-2">
    <label for="{{ $id }}" class="px-1 text-[16px] font-medium text-calm-text">{{ $label }}</label>

    <input id="{{ $id }}"
           name="{{ $name }}"
           type="{{ $type }}"
           @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
           @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
           @if ($error) aria-invalid="true" @endif
           {{ $attributes->class([
               'min-h-[56px] w-full rounded-[18px] border-[1.5px] bg-calm-surface px-5 text-[18px] text-calm-text placeholder:text-calm-muted focus-visible:outline-offset-2',
               'border-calm-sos' => $error,
               'border-calm-line' => ! $error,
           ]) }}>

    @if ($hint)
        <p id="{{ $id }}-hint" class="px-1 text-[15px] leading-[1.45] text-calm-muted">{{ $hint }}</p>
    @endif

    @if ($error)
        <p id="{{ $id }}-error" class="px-1 text-[15px] leading-[1.45] text-calm-sos">{{ $error }}</p>
    @endif
</div>
