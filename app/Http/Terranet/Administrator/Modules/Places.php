<?php

namespace App\Http\Terranet\Administrator\Modules;

use App\Http\Terranet\Administrator\Dashboard\BlankPanel;
use App\Http\Terranet\Administrator\Dashboard\CustomMetric;
use App\Http\Terranet\Administrator\Fields\CustomField;
use App\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Terranet\Administrator\Collection\Mutable;
use Terranet\Administrator\Contracts\Module\Editable;
use Terranet\Administrator\Contracts\Module\Exportable;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Navigable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Module\Validable;
use Terranet\Administrator\Dashboard\Manager;
use Terranet\Administrator\Dashboard\Row;
use Terranet\Administrator\Field\BelongsTo;
use Terranet\Administrator\Field\BelongsToMany;
use Terranet\Administrator\Field\HasOne;
use Terranet\Administrator\Field\Media;
use Terranet\Administrator\Field\Translatable as TranslatableField;
use Terranet\Administrator\Filter\Text;
use Terranet\Administrator\Scaffolding;
use Terranet\Administrator\Traits\Module\AllowFormats;
use Terranet\Administrator\Traits\Module\AllowsNavigation;
use Terranet\Administrator\Traits\Module\HasFilters;
use Terranet\Administrator\Traits\Module\HasForm;
use Terranet\Administrator\Traits\Module\HasSortable;
use Terranet\Administrator\Traits\Module\ValidatesForm;
use function localizer\locale;

/**
 * Administrator Resource Places
 *
 * @package Terranet\Administrator
 */
class Places extends Scaffolding implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats, AllowsNavigation;

    /**
     * The module Eloquent model
     *
     * @var string
     */
    protected $model = Place::class;

    public function columns(): Mutable
    {
        return $this->scaffoldColumns()
            ->push(HasOne::make('Place Details', 'details'))
            ->push(BelongsTo::make('City'))
            ->push(Media::make('images'))
            ;
    }

    public function form()
    {
        return $this->scaffoldForm()
            ->update('description', function (TranslatableField $field) {
                return $field->tinymce();
            })
            ->push(CustomField::make('custom_view'))
            ->push(HasOne::make('Place Details', 'details'))
            ->push(BelongsTo::make('Belongs to City', 'city')->searchable(false))
            ->push(BelongsToMany::make('Belongs to Tags', 'tags')->tagList())
            ;
    }

    public function viewColumns(): Mutable
    {
        return $this->columns();
    }

    public function filters(): Mutable
    {
        return $this->scaffoldFilters()
            ->push(Text::make('Phone')->setQuery(function (Builder $builder, $value) {
                return $builder
                    ->join('place_details as pd', 'pd.place_id', '=', 'places.id')
                    ->where('phone', $value);
            }))
            ;
    }

    public function sortable(): array
    {
        return array_merge(
            $this->scaffoldSortable(),
            [
                'name' => function (Builder $builder, string $column, string $direction) {
                    return $builder->join('place_translations as pt', function (JoinClause $join) {
                        $join->on('pt.place_id', '=', 'places.id')
                            ->where('pt.language_id', locale()->id());
                    })->orderBy('pt.name', $direction);
                },
            ]
        );
    }

    public function cards(): Manager
    {
        return (new Manager())->row(function (Row $row) {
            $row->panel(new BlankPanel())->setWidth(12);
        });
    }

    public function widgets(): Manager
    {
        /** @var Place $place */
        $place = app('scaffold.model');

        $cards = new Manager();
        $cards->row(function (Row $row) use ($place) {
            $row->panel(new CustomMetric($place))->setWidth(6);
            $row->panel(new CustomMetric($place))->setWidth(6);
        });
        $cards->row(function (Row $row) use ($place) {
            $row->panel(new CustomMetric($place))->setWidth(12);
        });

        return $cards;
    }

    public function rules()
    {
        return array_merge($this->scaffoldRules(), [
            'translatable.*.description' => 'required',
        ]);
    }

    public function messages()
    {
        return [
//            'required' => 'This is the custom message for required error.'
        ];
    }
}
