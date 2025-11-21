<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function view(User $user, Product $product)
    {
        return isAdmin() || $product->user_id == $user->id;
    }

    public function create(User $user)
    {
        return isAdmin() || isClinician();
    }

    public function update(User $user, Product $product)
    {
        return isAdmin() || $product->user_id == $user->id;
    }

    public function delete(User $user, Product $product)
    {
        return isAdmin() || $product->user_id == $user->id;
    }
}
