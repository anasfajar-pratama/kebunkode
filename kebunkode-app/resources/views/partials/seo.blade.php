@php
    use App\Support\Seo;

    $seo = !empty($seo) ? $seo : Seo::make('global');
    $ogImage = Seo::imageUrl($seo['og_image'] ?? null);
    $twitterImage = Seo::imageUrl($seo['twitter_image'] ?? null) ?: $ogImage;
    $structured = $seo['structured_data'] ?? null;
@endphp
    <title>{{ $seo['title'] ?? config('app.name') }}</title>
    @if(!empty($seo['description']))
    <meta name="description" content="{{ $seo['description'] }}" />
    @endif
    @if(!empty($seo['keywords']))
    <meta name="keywords" content="{{ $seo['keywords'] }}" />
    @endif
    <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}" />
    @if(!empty($seo['canonical']))
    <link rel="canonical" href="{{ $seo['canonical'] }}" />
    @endif
    @if(!empty($seo['google_site_verification']))
    <meta name="google-site-verification" content="{{ $seo['google_site_verification'] }}" />
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}" />
    <meta property="og:title" content="{{ $seo['og_title'] ?? ($seo['title'] ?? '') }}" />
    @if(!empty($seo['og_description']))
    <meta property="og:description" content="{{ $seo['og_description'] }}" />
    @endif
    <meta property="og:url" content="{{ $seo['og_url'] ?? url()->current() }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    @if($ogImage)
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}" />
    <meta name="twitter:title" content="{{ $seo['twitter_title'] ?? ($seo['title'] ?? '') }}" />
    @if(!empty($seo['twitter_description']))
    <meta name="twitter:description" content="{{ $seo['twitter_description'] }}" />
    @endif
    @if($twitterImage)
    <meta name="twitter:image" content="{{ $twitterImage }}" />
    @endif
    @if(!empty($seo['twitter_site']))
    <meta name="twitter:site" content="{{ $seo['twitter_site'] }}" />
    @endif

    {{-- Structured Data (JSON-LD) --}}
    @if(!empty($structured))
    <script type="application/ld+json">{!! $structured !!}</script>
    @endif

    {{-- Google Tag Manager --}}
    @if(!empty($seo['google_tag_manager_id']))
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $seo['google_tag_manager_id'] }}');</script>
    @endif

    {{-- Google Analytics --}}
    @if(!empty($seo['google_analytics_id']))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seo['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $seo['google_analytics_id'] }}');
    </script>
    @endif
