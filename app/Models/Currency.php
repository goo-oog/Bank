<?php
declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Currency
 *
 * @property string $symbol
 * @property float $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereRate($value)
 * @method static Builder|Currency whereSymbol($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Currency extends Model
{
    use HasFactory;

    protected $primaryKey = 'symbol';

    protected $keyType = 'string';

    protected $fillable = [
        'symbol',
        'rate'
    ];
}
