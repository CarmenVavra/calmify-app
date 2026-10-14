@if (session('status'))
    <p role="status" class="rounded-[24px] bg-calm-surface px-5 py-4 text-[17px] leading-[1.45] text-calm-text">
        {{ session('status') }}
    </p>
@endif
