<?php

namespace App;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo as BaseMorphTo;
use Illuminate\Support\Collection;

class MorphTo extends BaseMorphTo
{
    public function getForeignKeyForModel(string $type, Model $model = null)
    {
        if ($model === null) {
            return null;
        }

        return "{$model->{$type}}_id";
    }

    public function __construct(Builder $query, Model $parent, $foreignKey, $ownerKey, $type, $relation)
    {
        $foreign = $this->getForeignKeyForModel($type, $parent) ?: $foreignKey;

        parent::__construct($query, $parent, $foreign, $ownerKey, $type, $relation);
    }

    public function associate($model)
    {
        if ($model instanceof Model) {
            $this->foreignKey = $model->getMorphClass().'_id';
        }

        return parent::associate($model);
    }

    protected function buildDictionary(Collection $models)
    {
        foreach ($models as $model) {
            if ($model->{$this->morphType}) {
                $morphTypeKey = $this->getDictionaryKey($model->{$this->morphType});
                $foreignKeyKey = $this->getDictionaryKey($model->{$this->getForeignKeyForModel($this->morphType, $model)});

                $this->dictionary[$morphTypeKey][$foreignKeyKey][] = $model;
            }
        }
    }
}
