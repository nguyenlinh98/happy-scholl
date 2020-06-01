<?php

namespace App\Traits\Models;

trait DepartmentSettingTrait
{
    /**
     * Custom function to sync receivers on a morphMany relationships.
     */
    public function classesSync(string $morphingClass, array $morphingIds, string $relationship, string $foreignKey)
    {
        $this ->getListDepartmentBySchool($this->school_id);
        if (0 !== count($morphingIds)) {
            foreach ($morphingIds as $id) {
                $this->{$relationship}()->create([
                    'class_id' => (int) $id,
                    $foreignKey => $this->id,
                ]);
            }
        }
    }
}
