@props(['is_not_title_page' => true])

<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- ── Title ─────────────────────────────────────────── --}}
  <title>{{ $meta['full_title'] ?? ($title ?? config('app.name', 'Trufel')) }}</title>

  {{-- ── Core SEO ──────────────────────────────────────── --}}
  <meta name="description"  content="{{ $meta['description'] ?? '' }}">
  <meta name="keywords"     content="{{ $meta['keywords'] ?? '' }}">
  <meta name="robots"       content="{{ $meta['robots'] ?? (config('app.indexable') ? 'index, follow' : 'noindex, nofollow') }}">
  <meta name="author"       content="{{ config('seo.site_name', 'Trufel') }}">
  <meta name="theme-color"  content="#A09890">
  <link rel="icon" href="/favicon.svg" type="image/svg+xml">
  <link rel="alternate icon" href="/favicon.ico" type="image/x-icon">
  <link rel="canonical"     href="{{ $meta['canonical'] ?? request()->url() }}">

  {{-- ── Open Graph ────────────────────────────────────── --}}
  <meta property="og:type"        content="{{ $meta['og_type'] ?? 'website' }}">
  <meta property="og:site_name"   content="{{ $meta['og_site_name'] ?? config('seo.site_name') }}">
  <meta property="og:locale"      content="{{ $meta['og_locale'] ?? 'uk_UA' }}">
  <meta property="og:title"       content="{{ $meta['og_title'] ?? $title ?? '' }}">
  <meta property="og:description" content="{{ $meta['og_description'] ?? '' }}">
  <meta property="og:url"         content="{{ $meta['og_url'] ?? request()->url() }}">
  @if(!empty($meta['og_image']))
  <meta property="og:image"       content="{{ $meta['og_image'] }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt"   content="{{ $meta['og_title'] ?? config('seo.site_name') }}">
  @endif

  {{-- ── JSON-LD structured data ─────────────────────────── --}}
  @if(!empty($meta['json_ld']))
    @foreach($meta['json_ld'] as $schema)
    <script type="application/ld+json">
      {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>
    @endforeach
  @endif

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    [x-cloak] { display: none !important; }
  </style>
</head>

<body x-data="" @class(['font-alice', 'text-brand-text', 'bg-brand-cream', 'flex', 'flex-col', 'overflow-x-hidden', 'h-screen' => $is_not_title_page])>
  @if (Request::is('/'))
    @include('layouts.navigation-title')
  @else
    @include('layouts.navigation-general')
  @endif
  <main class="mb-auto mx-auto max-w-5xl w-full">
   {{ $slot }}
  </main>
  @include('layouts.footer')
  @include('layouts.modal-order')
</body>

</html>
