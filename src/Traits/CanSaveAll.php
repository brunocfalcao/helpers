<?php

namespace Brunocfalcao\Helpers\Traits;

use Illuminate\Support\Arr;

trait CanSaveAll
{
    /**
     * Saves all given items in the respective model.
     * E.g.: Car::saveAll([ ['brand=> 'mercedes'], ['brand' => 'Nissan']]).
     *
     * Returns the saved models collection.
     *
     * @return Collection|Model
     */
    public static function saveAll(array $dataItems)
    {
        $createdModels = collect();

        //1 level deep? wrap it.
        if (! is_array(optional($dataItems)[0])) {
            $dataItems = Arr::wrap([$dataItems]);
        }

        collect($dataItems)->each(function ($dataItem) use (&$createdModels) {
            $model = new static;

            collect($dataItem)->each(function ($value, $key) use ($model, &$createdModels) {
                $model->{$key} = $value;
            });

            $model->save();

            $createdModels->push($model);
        });

        // For simplicity, return the model instance in case we just have
        // one model in the collection.
        if ($createdModels->count() == 1) {
            return $createdModels[0];
        }

        return $createdModels;
    }
}
