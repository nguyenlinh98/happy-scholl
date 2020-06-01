<?php

namespace App\Traits\Models;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait HasClassDepartmentGroupRelationshipTrait
{
    public static $_SCHOOL_CLASS_RELATIONSHIP = 'school_classes';
    public static $_CLASS_GROUP_RELATIONSHIP = 'class_groups';
    public static $_DEPARTMENT_RELATIONSHIP = 'departments';

    /**
     * Loop through all predefined relation of school classes, groups and departments and prepare data for confirmation.
     *
     * @param string $prefix Prefix used in request
     */
    public function confirmClassDepartmentGroupRelationship(string $prefix, bool $single = false)
    {
        $list = hsp_block_index();
        foreach ($list as $relationName) {
            if (request()->has($prefix.$relationName)) {
                if (true === $single && request()->input($prefix.'select') !== $relationName) {
                    hsp_debug('skip_relation', $relationName);

                    continue;
                }
                hsp_debug('process_relation', $relationName);
                $classRelation = $this->convertToClass($relationName);
                $result = (new $classRelation())->whereIn('id', request()->input($prefix.$relationName))->get();
                $this->setAttribute($prefix.$relationName, $result);
            }
        }
    }

    /**
     * Loop through all predefined relation of school classes, groups and departments and prepare data for edit.
     *
     * Write data to session cache.
     *
     * @param string $relationship method name on parent model
     * @param string $prefix       Prefix used in request
     * @param string $morph        morph prefix eg "manage_id" then $morph is "manage"
     */
    public function prepareClassDepartmentGroupRelationship(string $relationships, string $prefix, string $morph)
    {
        session()->flash('_old_input', null);

        if ('BelongsToMany' === class_basename($this->{$relationships}())) {
            hsp_debug('BelongsToMany relation list', $this->{$relationships});

            return true;
        }

        $this->loadMissing($relationships);
        $collection = collect($this->{$relationships});

        foreach ($collection->groupBy($morph.'_type') as $group) {
            $relationName = $this->convertToRequestFormName(data_get($group->first(), $morph.'_type'));
            hsp_debug('morph many relation list', ["{$prefix}{$relationName}", $group->toArray()]);

            session(["_old_input.{$prefix}{$relationName}" => $group->pluck($morph.'_id')->toArray()]);
        }
    }

    /**
     * Loop through all predefined relation of school classes, groups and departments and prepare data for edit.
     *
     * Write data to session cache.
     *
     * @param string $relationship method name on parent model
     * @param string $prefix       Prefix used in request
     * @param string $morph        morph prefix eg "manage_id" then $morph is "manage"
     */
    public function prepareSimpleClassDepartmentGroupRelationship(string $relationships, string $prefix, string $type)
    {
        session()->flash('_old_input', null);
        $this->loadMissing($relationships);
        $collection = collect($this->{$relationships});

        session(["_old_input.{$prefix}{$type}" => $collection->pluck('id')->toArray()]);
    }

    /**
     * Loop through all predefined relation of school classes, groups and departments and get data from request.
     *
     * @param string $relationship Name of relation method on this class
     * @param string $className    Class to store relation info
     * @param string $morph        morph prefix
     * @param string $prefix       Prefix used in request
     */
    public function processClassDepartmentGroupRelationship(string $relationship, string $className, string $morph, string $prefix, bool $single = false)
    {
        throw_if(!method_exists($this, $relationship), InvalidArgumentException::class, "Relation {$relationship} not found");
        $this->{$relationship}()->delete();

        $list = hsp_block_index();
        if ($single) {
            $this->processEachRelationship(request()->input($prefix.'select'), $relationship, $className, $morph, $prefix);
        } else {
            foreach ($list as $relationName) {
                $this->processEachRelationship($relationName, $relationship, $className, $morph, $prefix);
            }
        }
    }

    private function processEachRelationship(string $relationName, string $relationship, string $className, string $morph, string $prefix)
    {
        if (request()->has($prefix.$relationName)) {
            // TODO: Handle multiple relation type
            if ('BelongsToMany' === class_basename($this->{$relationship}())) {
                $this->{$relationship}()->sync(request()->input($prefix.$relationName, []));

                return true;
            }
            if ('HasMany' === class_basename($this->{$relationship}())) {
                if ('' !== $morph) {
                    $morphType = "{$morph}_type";
                    $morphId = "{$morph}_id";
                    foreach (request()->input($prefix.$relationName, []) as $item) {
                        $relation = new $className();
                        $relation->{$morphType} = $this->convertToClass($relationName);
                        $relation->{$morphId} = $item;
                        $this->{$relationship}()->save($relation);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    private function convertToClass(string $name)
    {
        return 'App\\Models\\'.Str::studly(Str::singular($name));
    }

    private function convertToRequestFormName(string $class)
    {
        return Str::plural(Str::snake(class_basename($class)));
    }
}
