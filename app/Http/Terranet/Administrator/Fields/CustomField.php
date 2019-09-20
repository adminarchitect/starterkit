<?php

namespace App\Http\Terranet\Administrator\Fields;

use Illuminate\Support\Str;
use Terranet\Administrator\Field\Field;

class CustomField extends Field
{
    public function onEdit()
    {
        return [
            'data' => 'test',
        ];
    }

    protected function template(string $page, string $field = null): string
    {
        return sprintf(
            'admin.fields.%s.%s',
            Str::snake($field ?? class_basename($this)),
            $page
        );
    }
}
