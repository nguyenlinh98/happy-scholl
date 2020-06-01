<?php

namespace App\Traits\Models;

trait HasReceiverTrait
{
    /**
     * Custom function to sync receivers on a morphMany relationships.
     */
    public function receiversSync(string $morphingClass, array $morphingIds, string $relationship, string $foreignKey)
    {
        $this->{$relationship}()->delete();
        if (0 !== count($morphingIds)) {
            foreach ($morphingIds as $id) {
                $this->{$relationship}()->create([
                    'receiver_type' => $morphingClass,
                    'receiver_id' => (int) $id,
                    $foreignKey => $this->id,
                ]);
            }
        }
    }
}
