<!doctype html>
<html @php(language_attributes())>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php(do_action('get_header'))
        @php(wp_head())
        @include('utils.styles')
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>

    <body @php(body_class())>
        @php(wp_body_open())

        <div id="app">
            <main id="main" class="overflow-x-hidden">
                <div class="">
                    @yield('content')
                </div>
            </main>

            @include('sections.footer')
        </div>

        @include('partials.phone')
        @php(do_action('get_footer'))
        @php(wp_footer())
        @include('utils.scripts')
    </body>
</html>
