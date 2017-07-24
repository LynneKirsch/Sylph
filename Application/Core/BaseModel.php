<?php

namespace Application\Core;

class BaseModel
{
    /**
     * Takes an array of key=>val associations and
     * sets them on the child entity.
     *
     * @param array $user_input
     * @throws \Exception
     */
    public function load(array $user_input)
    {
        foreach ($user_input as $key => $value) {

            /**
             * Replaces _ with space, uppercases string, then
             * smashes it.
             *
             * All set methods should follow this pattern.
             * Property/Column name: user_id
             * Set method: setUserId
             */
            $set_method = "set" . str_replace(
                    " ", "", ucwords(
                        str_replace("_", " ", $key)
                    )
                );

            if (method_exists(get_called_class(), $set_method)) {
                $this->{$set_method}($value);
            }
        }
    }
}