<?php

namespace Brunocfalcao\Helpers\Traits;

trait CanSaveAll
{
    /**
     * Saves all given items in the respective model.
     * E.g.: $Car->saveAll([ ['brand=> 'mercedes'], ['brand' => 'Nissan']]).
     *
     * Returns the saved models collection.
     *
     * @param  array  $dataItems
     * @return Collection
     */
    public static function saveAll(array $dataItems)
    {
        $createdModels = collect();

        collect($dataItems)->each(function ($dataItem) use (&$createdModels) {
            $model = new static;

            collect($dataItem)->each(function ($value, $key) use ($model, &$createdModels) {
                $model->{$key} = $value;
            });

            $model->save();

            $createdModels->push($model);
        });

        return $createdModels;
    }
}
