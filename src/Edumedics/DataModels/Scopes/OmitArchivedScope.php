<?php

namespace Edumedics\DataModels\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OmitArchivedScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
       $builder->whereNull('archived')->orWhere('archived', '!=', true);
    }

}