<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use ReflectionClass;

class DTO
{
    public function __construct(FormRequest $request)
    {
        $object = new ReflectionClass(static::class);
        foreach ($object->getProperties() as $property) {
            $key = $property->getName();
            if ($request->has(Str::snake($key))) {
                $this->{Str::camel($key)} = $request->get(Str::snake($key));
            }

        }

    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $data = [];
        /**
         * @phpstan-ignore-next-line
         */
        foreach ($this as $key => $value) {
            $data[Str::snake($key)] = $value;
        }

        return $data;
    }
}
