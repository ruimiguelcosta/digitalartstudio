@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background">
    @include('partials.hero')
    @include('partials.about')
    @include('partials.services')
    @include('partials.portfolio')
    @include('partials.contact')
    @include('partials.footer')
</div>
@endsection

