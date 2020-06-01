<?php

use App\Models\School;
use App\Models\SchoolSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('hsp_title')) {
    // smart guest title from route name
    function hsp_title()
    {
        $sharedTitle = view()->shared('hsp_title');
        if (filled($sharedTitle)) {
            return $sharedTitle;
        }

        $routeName = Str::after(request()->route()->getName(), 'admin.');

        $routeComponents = explode('.', $routeName);

        if (1 === count($routeComponents)) {
            $routeNameToLocalizeString = $routeName;
        } else {
            $guessedModel = array_shift($routeComponents);
            // insert .title. between first and rest of array
            $routeNameToLocalizeString = implode('.', array_merge([$guessedModel], ['title'], $routeComponents));
        }

        $payload = isset($guessedModel) ? view()->shared($guessedModel) ?: [] : [];
        if (filled($payload)) {
            if (!is_array($payload)) {
                if (method_exists($payload, 'toArray')) {
                    $payload = $payload->toArray();
                } else {
                    $payload = (array) $payload;
                }
            }
        }
        // convert route name to localize string with auto guest payload

        return __($routeNameToLocalizeString, $payload);
    }
}

    if (!function_exists('hsp_action')) {
        /**
         * Return translated string for action based on route name.
         *
         * @return string translated string
         * */
        function hsp_action(string $action)
        {
            $routeName = array_first(hsp_route());

            $localizedAction = implode('.', [$routeName, 'action', $action]);

            // convert route name to localize string with auto guest payload

            return __($localizedAction);
        }
    }

    if (!function_exists('hsp_route')) {
        /**
         * Return list of route route bits.
         *
         * @param int items to get from route name, start from left, default 1
         *
         * @return array extracted from route name, default 1
         * */
        function hsp_route(int $count = 1)
        {
            $routeName = Str::after(request()->route()->getName(), 'admin.');

            if (blank($routeName)) {
                return '';
            }
            $routeComponents = explode('.', $routeName);

            if (1 === count($routeComponents)) {
                //only 1 item, skip count
                return [$routeComponents[0]];
            }

            return array_slice($routeComponents, 0, $count);
        }
    }

    if (!function_exists('hsp_time_generator')) {
        /**
         * Return array of time from 0h to 24h.
         *
         * @param int    $step   minutes to increase, default 15 mins
         * @param string $format time
         *
         * @return array of times
         * */
        function hsp_time_generator(int $step = 60 * 15, string $format = '')
        {
            $times = [];

            if (empty($format)) {
                $format = 'H:i';
            }

            //$times['XXX'] = 'すぐ送る';

            foreach (range(0, 86400 /* full day */, $step) as $increment) {
                $increment = gmdate('H:i', $increment);

                list($hour, $minutes) = explode(':', $increment);

                $date = new DateTime($hour.':'.$minutes);

                $times[(string) $increment] = $date->format($format);
            }

            return $times;
        }
    }

    if (!function_exists('hsp_date_generator')) {
        /**
         * Return array of time from 0h to 24h.
         *
         * @param string $end_date strtotime format for end date limit, strtotime compatible, default '+1 month'
         * @param string $format   date, default 'Y年M月D日（ddd）'
         *
         * @return array of dates
         * */
        function hsp_date_generator(string $start_date = 'now', string $end_date = '+1 month', string $format = 'Y年M月D日（ddd）')
        {
            $dates = [];
            $period = new Carbon\CarbonPeriod($start_date, $end_date);
            foreach ($period as $date) {
                $dates[$date->format('Y-m-d')] = $date->locale('ja')->isoFormat($format);
            }

            return $dates;
        }
    }

    if (!function_exists('hsp_school')) {
        /**
         * Return school model get from user school_id.
         *
         * @return App\Models\School
         */
        function hsp_school()
        {
            return cache()->remember('hsp_school_'.auth()->user()->school->id, 10, function () {
                return School::where('id', auth()->user()->school->id)->withCount('schoolClasses')->first();
            });
        }
    }

    if (!function_exists('hsp_setting')) {
        /**
         * Return setting value by key from current school.
         *
         * @param string $setting Setting value from table 'school_settings', if empty or not set, return all setting
         *
         * @return App\Models\School
         */
        function hsp_setting(string $setting = '')
        {
            $school = hsp_school();
            $settings = cache()->remember('hsp_setting_'.$school->id, 10, function () use ($school) {
                return SchoolSetting::where('school_id', $school->id)->first();
            });
            if ('' === $setting) {
                return $settings;
            }

            return data_get($settings, $setting, false);
        }
    }

    if (!function_exists('hsp_checkbox_state')) {
        /**
         * Compare checkbox value with old input to determine checked stage.
         *
         * @version 1.0.0
         *
         * @return string $stage
         */
        function hsp_checkbox_state(string $name, string $value, string $default = null)
        {
            if (Str::endsWith($name, '[]')) {
                $inputName = Str::before($name, '[]');
                // if this input is array
                $checked = in_array($value, old($inputName, []));
            } else {
                $checked = old($name, $default) === $value;
            }

            return $checked ? 'checked="checked"' : '';
        }
    }
    if (!function_exists('hsp_getConfig')) {
        /**
         * @param $key
         * @param null $default
         * @param $flip
         *
         * @return mixed
         */
        function hsp_getConfig($key, $default = null, $flip = false)
        {
            $dir = 'core.config.';
            if (app('config')->has($dir.$key)) {
                $r = config($dir.$key, $default);
            } else {
                $r = config('core.config.'.$key, $default);
            }

            return is_array($r) && $flip ? array_flip($r) : $r;
        }
    }

    if (!function_exists('hsp_getTitle')) {
        /**
         * @param $key
         * @param null $default
         * @param $flip
         *
         * @return mixed
         */
        function hsp_getTitle($default = null, $flip = false)
        {
            $dir = 'core.config.';
            $routeName = Str::after(request()->route()->getName(), 'admin.');
            $routeComponents = explode('.', $routeName);
            if (1 === count($routeComponents)) {
                $routeNameToLocalizeString = $routeName;
            } else {
                $guessedModel = array_shift($routeComponents);
                // insert .title. between first and rest of array
                $routeNameToLocalizeString = 'sidebar_menus.'.$guessedModel.'.title';
            }
            if (app('config')->has($dir.$routeNameToLocalizeString)) {
                $r = config($dir.$routeNameToLocalizeString, $default);
            } else {
                $r = config('core.config.'.$routeNameToLocalizeString, $default);
            }

            return is_array($r) && $flip ? array_flip($r) : $r;
        }
    }

    if (!function_exists('hsp_uuid')) {
        /**
         * shortcut to generate uuid.
         */
        function hsp_uuid()
        {
            return Str::uuid();
        }
    }

    if (!function_exists('hsp_debug')) {
        /**
         * Create debug log.
         */
        function hsp_debug()
        {
            if (env('APP_DEBUG')) {
                $arguments = func_get_args();

                $debugger = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                $functionName = isset($debugger[1]['function']) ? 'function::'.$debugger[1]['function'] : '';
                $className = isset($debugger[1]['class']) ? 'class::'.$debugger[1]['class'] : '';
                logger(array_merge(array_filter([$className, $functionName]), $arguments));
            }
        }
    }

    if (!function_exists('hsp_block_index')) {
        /**
         * Get block name from index.
         */
        function hsp_block_index($index = false)
        {
            $TYPES = [
                '1' => 'school_classes',
                '2' => 'departments',
                '3' => 'class_groups',
            ];
            if (false === $index) {
                return $TYPES;
            }

            return isset($TYPES[$index]) ? $TYPES[$index] : '';
        }
    }

    if (!function_exists('hsp_class_group_department_block_display')) {
        /**
         * The logic was to complicated to keep in view.
         */
        function hsp_class_group_department_block_display($selectName, $type, $template, $multipleSelect = true)
        {
            if ($multipleSelect) {
                return 'block';
            }
            if (1 === strlen($type)) {
                return 'block';
            }

            $typeString = strval($type);

            $firstType = hsp_block_index(strval($typeString[0]));

            if (old($selectName, $firstType) === $template) {
                return 'block';
            }

            return 'none';
        }
    }

    if (!function_exists('hsp_code_group_select')) {
        /**
         * Get code array from group_id in code_masters.
         *
         * return array of code mapped for select component
         */
        function hsp_code_masters_group($group_id)
        {
            $codeGroups = cache()->remember("code_masters__{$group_id}", 10, function () use ($group_id) {
                return DB::table('code_masters')->where('group_code', $group_id)->get();
            });

            return $codeGroups->mapWithKeys(function ($item) {
                return [$item->code => $item->name];
            });
        }
    }

    if (!function_exists('hsp_code_masters_value')) {
        /**
         * Get code array from group_id in code_masters.
         *
         * return array of code mapped for select component
         */
        function hsp_code_group_select($group_id, $code_id)
        {
            return cache()->remember("code_masters__{$group_id}__{$code_id}", 10, function () use ($group_id, $code_id) {
                $codeName = DB::table('code_masters')->where('group_code', $group_id)->where('code', $code_id)->select('name')->first();

                return $codeName ? $codeName->name : '';
            });
        }
    }

    if (!function_exists('hsp_unlink_dir')) {
        /**
         * Remove directory and it's content.
         */
        function hsp_unlink_dir($dir)
        {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? hsp_unlink_dir("$dir/$file") : unlink("$dir/$file");
            }

            return rmdir($dir);
        }
    }
