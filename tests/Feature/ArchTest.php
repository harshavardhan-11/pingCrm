<?php

it('does not use debugging functions', function (){
    expect(['dd', 'dump', 'ray'])
        ->not->toBeUsed();
});

it('uses only redirect facade for redirection', function () {
    expect(['back', 'redirect', 'to_route'])
        ->not->toBeUsedIn('App\Http\Controllers');
});
