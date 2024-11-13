<?php

namespace App\Http\Requests\Attributes;

use App\Enums\Permission\CategoryEnum as Permission;
use App\Models\Attributes\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getRedirectRoute(): string
    {
        return route('admin.attributes.edit', $this->route('attribute'));
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(Permission::EDIT->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('attribute')->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique(Attribute::class, 'name')->ignore($id)]
        ];
    }
}
