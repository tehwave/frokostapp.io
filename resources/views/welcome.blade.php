<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FROKOST</title>
        <meta name="description" content="Choose who's gonna get lunch with an impartial robot.">

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
    </head>
    <body class="h-100">
        <div class="jumbotron jumbotron-fluid h-100 mb-0" style="background-image: url({{ asset('images/lunch.jpg') }}); background-size: cover;">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col col-lg-6 my-auto">
                        <div class="card shadow-lg border-0 text-center">
                            <div class="card-header bg-pattern p-4">
                                {{--  --}}
                            </div>
                            <div class="card-body p-6">
                                <h1 class="display-3 text-danger">FROKOST</h1>
                                <p class="lead">Choose who's gonna get lunch with an impartial robot.</p>
                                <a href="{{ route('slack.redirect') }}"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" />
                                    <span class="sr-only">
                                        Add to Slack
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ mix('js/manifest.js') }}"></script>
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>
