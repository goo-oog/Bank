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
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $account_id
 * @property string $partner_account
 * @property string $description
 * @property int $amount
 * @property string $currency
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Account $account
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAccountId($value)
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereCurrency($value)
 * @method static Builder|Transaction whereDescription($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction wherePartnerAccount($value)
 * @method static Builder|Transaction whereType($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Transaction extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'account_id',
        'partner_account',
        'description',
        'amount',
        'currency',
        'type'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
