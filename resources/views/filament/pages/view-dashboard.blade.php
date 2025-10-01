@extends('filament::page')

@section('content')
    <div class="space-y-4">
        <h1 class="text-2xl font-bold mb-4">{{ $dashboard->name }}</h1>
        <p class="mb-4">{{ $dashboard->description }}</p>
        <div class="aspect-w-16 aspect-h-9">
            <iframe src="{{ $dashboard->url }}" frameborder="0" allowfullscreen class="w-full h-[80vh] rounded shadow"></iframe>
        </div>
    </div>
@endsection
