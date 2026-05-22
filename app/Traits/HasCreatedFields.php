<?php

namespace App\Traits;

/**
 * Automatically handle
 * created metadata fields.
 */
trait HasCreatedFields
{
    /**
     * Boot trait events.
     */
    protected static function bootHasCreatedFields(): void
    {
        static::creating(function ($model) {

            /**
             * Set creator ID
             * when authenticated.
             */
            if (auth()->check()) {

                $model->created_by = (string)
                    auth()->user()->_id;
            }

            /**
             * Set created timestamp.
             */
            if (!$model->created_time) {

                $model->created_time = now();
            }
        });
    }
}