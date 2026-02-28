<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        if (!$this->product) {
            return 0;
        }
        return $this->product->current_price * $this->quantity;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'DOP $' . number_format($this->subtotal, 2);
    }

    // Methods
    public function increaseQuantity($amount = 1)
    {
        $this->increment('quantity', $amount);
    }

    public function decreaseQuantity($amount = 1)
    {
        if ($this->quantity > $amount) {
            $this->decrement('quantity', $amount);
        } else {
            $this->delete();
        }
    }

    public function updateQuantity($quantity)
    {
        if ($quantity <= 0) {
            $this->delete();
        } else {
            $this->update(['quantity' => $quantity]);
        }
    }

    // Static methods
    public static function addItem($productId, $quantity = 1, $userId = null, $sessionId = null)
    {
        $cart = static::where('product_id', $productId)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cart) {
            $cart->increaseQuantity($quantity);
            return $cart;
        }

        return static::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    public static function getCartTotal($userId = null, $sessionId = null)
    {
        $query = static::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        return $query->get()->sum('subtotal');
    }

    public static function getCartCount($userId = null, $sessionId = null)
    {
        $query = static::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        return $query->sum('quantity');
    }

    public static function clearCart($userId = null, $sessionId = null)
    {
        $query = static::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        return $query->delete();
    }
}
