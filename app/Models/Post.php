<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Unusualdope\FilamentModelTranslatable\Models\FmtModel;

class Post extends FmtModel
{
    use HasFactory;

    protected $table = 'posts';
    protected $lang_model = 'App\Models\PostLanguage'; //fqn of the translatable model
    protected $lang_foreign_key = 'post_id'; //foreign key

    protected $is_translatable = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    protected $translatable = [
        'title' => [ //field name that will match with the LangModel db field and property
            'formType' => 'TextInput', //The type of form input field as in Filament
            'name' => 'Title', //Field Label
            'methods' => [ //The methods you want to call from filament on your field to define it
                'required' => '1',
                'prefix' => 'title',
            ],
        ],
        'content' => [
            'formType' => 'RichEditor',
            'name' => 'Content',
            'methods' => [
                'columnSpanFull' => '',
            ],
        ],
    ];


    public static function getForm(): array
    {
        return [
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required()
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postLanguages(): HasMany
    {
        return $this->hasMany(PostLanguage::class);
    }
}
