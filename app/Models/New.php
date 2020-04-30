<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property string $title
 * @property string $image
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 */
class NewModel extends Model
{
    use Uuid;
    /**
     * @var array
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = "news";

    protected $fillable = ['title', 'image', 'active', 'text'];
}
