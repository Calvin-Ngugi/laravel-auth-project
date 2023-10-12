@if($listing)
    <h2>{{ $listing['title'] }}</h2>
    <p>{{ $listing['description'] }}</p>
@else
    <p>No listing found.</p>
@endif