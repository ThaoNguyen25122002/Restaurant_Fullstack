<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
Broadcast::channel('admin.orders', function ($user) {
    // dd(123);
    return $user->role_id === 1 ? $user : null; 
});