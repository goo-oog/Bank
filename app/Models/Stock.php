<?php
declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Account $account
 * @method static Builder|Stock newModelQuery()
 * @method static Builder|Stock newQuery()
 * @method static Builder|Stock query()
 * @method static Builder|Stock whereAccountId($value)
 * @method static Builder|Stock whereAmount($value)
 * @method static Builder|Stock whereBuyPrice($value)
 * @method static Builder|Stock whereCreatedAt($value)
 * @method static Builder|Stock whereId($value)
 * @method static Builder|Stock whereIsActive($value)
 * @method static Builder|Stock whereSellPrice($value)
 * @method static Builder|Stock whereSymbol($value)
 * @method static Builder|Stock whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Stock extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'account_id',
        'is_active',
        'symbol',
        'amount',
        'buy_price',
        'sell_price'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
