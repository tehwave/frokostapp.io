<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Settings – FROKOST</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
    </head>
    <body class="h-100">
        <div class="jumbotron jumbotron-fluid h-100 mb-0 bg-danger">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-6">
                        <form method="POST" action="{{ route('slack.settings.update', $slack) }}" class="card shadow border-0 rounded">
                            @method('PUT')
                            @csrf

                            <div class="card-header text-center">
                                <h1 class="card-title my-4 text-danger">
                                    Settings
                                </h1>
                                <div class="lead">{{ $slack->team_name }}</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="channel">Channel</label>
                                    <input name="channel" type="text" class="form-control" id="channel" placeholder="#general" value="{{ old('channel', $slack->setting('channel')) }}">
                                    <div class="form-text text-muted">
                                        Default channel is <code>#general</code>.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="amount">How many unlucky users to choose at a time</label>
                                    <input name="amount" type="number" class="form-control" id="amount" placeholder="1" value="{{ old('amount', $slack->setting('amount')) }}">
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary px-6">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="h-100 shadow rounded" style="background-image: url({{ asset('images/lunch.jpg') }}); background-size: cover;"></div>
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
