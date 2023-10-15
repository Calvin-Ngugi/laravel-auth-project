<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/listing.css">
    <title>Document</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="contain">
            <h2>Lorem texts</h2>
            @unless (count($listings) == 0)
                @foreach ($listings as $listing)
                    <div class="card mt-2 mb-3">
                        <div class="card-header">
                            <h4 class="card-title">
                                <a href="/listings/{{ $listing['id'] }}">{{ $listing['title'] }}</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ $listing['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <h4>No listings found</h2>
                @endunless
        </div>
    @endsection
</body>

</html>
