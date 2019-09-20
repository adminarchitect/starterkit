<?php

namespace App;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Terranet\Administrator\Annotations\ScopeFilter;
use Terranet\Translatable\HasTranslations;
use Terranet\Translatable\Translatable;

class Place extends Model implements Translatable, AttachableInterface, HasMedia
{
    use HasTranslations, PaperclipTrait {
        HasTranslations::getAttribute as getTranslatedAttribute;
        HasTranslations::setAttribute as setTranslatedAttribute;
        PaperclipTrait::getAttribute as getAttachmentAttribute;
        PaperclipTrait::setAttribute as setAttachmentAttribute;
    }
    use HasMediaTrait;

    /** @var array */
    protected $fillable = [
        'active',
        'image'
    ];

    /** @var array */
    protected $translatedAttributes = ['name', 'description'];

    /** @var array */
    protected $casts = [
        'active' => 'bool',
    ];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('image', [
            'variants' => [
                'medium' => [
                    'auto-orient' => [],
                    'resize' => ['dimensions' => '300x300'],
                ],
                'thumb' => '100x100',
            ],
            'attributes' => [
                'variants' => false,
            ],
        ]);

        parent::__construct($attributes);
    }

    public function getAttribute($key)
    {
        if ($this->isKeyReturningTranslationText($key)) {
            return $this->getTranslatedAttribute($key);
        }

        if (array_key_exists($key, $this->attachedFiles)) {
            return $this->getAttachmentAttribute($key);
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if ($this->isKeyReturningTranslationText($key)) {
            return $this->setTranslatedAttribute($key, $value);
        }

        if (array_key_exists($key, $this->attachedFiles)) {
            return $this->setAttachmentAttribute($key, $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @ScopeFilter()
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    /**
     * @ScopeFilter()
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeInactive(Builder $query)
    {
        return $query->where('active', false);
    }

    /**
     * @ScopeFilter(name="Callable", icon="fa-phone")
     * @param  Builder  $query
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeHavingPhone(Builder $query)
    {
        return $query->join('place_details as pd', 'pd.place_id', '=', 'places.id')
            ->whereNotNull('pd.phone');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'place_tags');
    }

    public function details(): HasOne
    {
        return $this->hasOne(PlaceDetails::class);
    }

    /**
     * @return $this
     */
    public function activate()
    {
        $this->active = true;
        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function deactivate()
    {
        $this->active = false;
        $this->save();

        return $this;
    }
}
