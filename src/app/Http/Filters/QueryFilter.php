<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QueryFilter
{
    /**
     * @var Builder<Model>
     */
    protected Builder $builder;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param  array<int>  $arr
     * @return Builder<Model>
     */
    protected function filter(array $arr): Builder
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    /**
     * @param  Builder<Model>  $builder
     * @return Builder<Model>
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }

    /**
     * @return Builder<Model>
     */
    public function orderBy(string $column): Builder
    {
        $direction = Str::charAt($column, 0) == '-' ? 'DESC' : 'ASC';
        $orderBy = Str::replace('-', '', $column);

        return $this->builder->orderBy($orderBy, $direction);
    }
}
