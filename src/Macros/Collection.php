<?php

use Illuminate\Support\Collection;

/*
 * Adds a new object in the specific index in the collection.
 * It changes the original collection, no need to use it as a return value.
 * E.g.: <mycollection>->addAt(new object(), 1) or <mycollection>->addAt('example.com', 3).
 *
 * @param      mixed   $mixed  Object to be added to the collection.
 * @param      integer $index  Zero-based index where it will be inserted (all others will be pushed forward).
 *                             Null? Appends at the end of the collection.
 *
 * @return Illuminate\Support\Collection
 */
Collection::macro('addAt', function ($mixed, int $index = null): Collection {
    return ! is_null($index) ? $this->splice($index, 0, [$mixed]) : $this->push($mixed);
});

/*
 * Verifies if all the values in the collection are equal to the argument.
 * E.g. Can be used to verify if all values are true, false, etc.
 *
 * @return     boolean If all values are of the same as $type, returns true. Else, returns false.
 */
Collection::macro('are', function ($type) {
    $filtered = $this->filter(function ($value, $key) use ($type) {
        return $value === $type;
    });

    return $filtered->count() === $this->count();
});

/*
 * Verifies if we have "at least" $num total entries in the collection.
 *
 * @param      integer  $num    At least these count.

 * @return Illuminate\Support\Collection
 */
Collection::macro('atLeast', function (int $num) {
    return $this->count() >= $num ? true : false;
});

/*
 * Get the firsts N items from the collection
 *
 * @param      integer  $num    How much items do we want.
 *
 * @return Illuminate\Support\Collection
 */
Collection::macro('firstN', function (int $num): Collection {
    return $this->slice(0, $num);
});

/*
 * Get the next item from the collection.
 *
 * @param mixed $currentItem
 * @param mixed $fallback
 *
 * @return mixed
 */
Collection::macro('after', function ($currentItem, $fallback = null) {
    $currentKey = $this->search($currentItem, true);
    if ($currentKey === false) {
        return $fallback;
    }
    $currentOffset = $this->keys()->search($currentKey, true);
    $next = $this->slice($currentOffset, 2);
    if ($next->count() < 2) {
        return $fallback;
    }

    return $next->last();
});

/*
 * Returns a collection to be used as a dropdownlist.
 *
 */
Collection::macro('dropdownList', function ($id, $description, $selectAnOptionText = 'Select an option', $selectAnOption = true) {
    $data = $this->pluck($description, $id);

    if ($selectAnOption) {
        $data->prepend($selectAnOptionText, '');
    }

    return $data;
});
