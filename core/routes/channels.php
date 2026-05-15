<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-chat', function ($user) {
    return true;
});
