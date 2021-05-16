<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Stock
 *
 * @property int $id
 * @property int $account_id
 * @property int $is_active
 * @property string $symbol
 * @property float $amount
 * @property int $buy_price
 * @property int|null $sell_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stock extends Model
{
    use HasFactory;

//    use SoftDeletes;

    protected $fillable = [
        'account_id',
        'is_active',
        'symbol',
        'amount',
        'buy_price',
        'sell_price',
//        'profit'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
