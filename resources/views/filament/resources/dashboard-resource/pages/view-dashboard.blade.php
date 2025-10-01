
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-800">{{ $dashboard->name }}</h1>
        <p class="text-gray-600 mt-2">{{ $dashboard->description }}</p>
    </div>

    @php
        $allowlist = [
            'app.powerbi.com',
            'metabase.',
            '44.219.14.81', // Exemplo enviado
        ];
        $parsed = parse_url($dashboard->url);
        $host = $parsed['host'] ?? '';
        $isAllowed = false;
        foreach ($allowlist as $domain) {
            if (str_contains($host, $domain)) {
                $isAllowed = true;
                break;
            }
        }
    @endphp

    @if ($isAllowed)
        <div class="w-full bg-gray-100 rounded shadow overflow-hidden border border-gray-200" style="height:92vh; min-height:600px;">
            <iframe
                src="{{ $dashboard->url }}"
                frameborder="0"
                allowfullscreen
                sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
                referrerpolicy="no-referrer"
                class="w-full h-full min-h-[600px] bg-white"
                style="border:0; height:100%; min-height:600px;"
            ></iframe>
        </div>
    @else
        <div class="bg-red-100 text-red-700 p-6 rounded shadow text-center">
            <strong>Não é possível exibir este dashboard.</strong><br>
            O domínio do link não está na lista de permitidos ou requer autenticação extra.<br>
            <span class="text-xs">Domínios permitidos: app.powerbi.com, metabase.*, 44.219.14.81</span>
        </div>
    @endif

    <div class="mt-6 flex flex-wrap gap-2 text-xs text-gray-500">
        <span class="inline-block bg-gray-200 rounded px-2 py-1">Plataforma: <b>{{ $dashboard->platform }}</b></span>
        <span class="inline-block bg-gray-200 rounded px-2 py-1">Visibilidade: <b>{{ $dashboard->visibility }}</b></span>
        <span class="inline-block bg-gray-200 rounded px-2 py-1">Escopo: <b>{{ $dashboard->scope }}</b></span>
        @if (!empty($dashboard->tags))
            <span class="inline-block bg-gray-200 rounded px-2 py-1">Tags:
                @foreach ($dashboard->tags as $tag)
                    <span class="ml-1">#{{ $tag }}</span>
                @endforeach
            </span>
        @endif
    </div>
</div>
