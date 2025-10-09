@php
    /** @var \Illuminate\Database\Eloquent\Model|null $record */
    $url = $record?->url ?? null;
@endphp

@if(filled($url))
    <div style="margin-top:1rem;">
        <div style="position:relative;padding-top:56.25%;overflow:hidden;border:1px solid #e5e7eb;border-radius:6px;">
            <iframe src="{{ $url }}" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;" sandbox="allow-scripts allow-same-origin allow-forms allow-popups"></iframe>
        </div>
    </div>
@else
    <p class="fi-muted">Nenhuma URL para visualização.</p>
@endif
