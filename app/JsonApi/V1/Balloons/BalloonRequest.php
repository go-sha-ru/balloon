<?php

namespace App\JsonApi\V1\Balloons;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BalloonRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'body' => ['required', 'string'],
            'title' => ['required', 'string'],
            'longitude' => ['required', 'string'],
            'latitude' => ['required', 'string'],
            'publishedAt' => ['nullable', JsonApiRule::dateTime()],
        ];
    }

}
