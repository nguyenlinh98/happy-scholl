<?php
/**
 * User: JohnAVu
 * Date: 2019-12-19
 * Time: 15:00
 */

/**
 * @param $text
 * @return string
 */
function translate($text)
{
    if (!$text) {
        return $text;
    }
//    return $text;
    if (Session::get('lang')) {
        $lang = Session::get('lang');
        if ($lang == Lang::getLocale()) {
            return $text;
        }
        return Trans::setTarget($lang)->get($text);
    }
//    return Trans::setTarget('vi')->get($text);
    return $text;
}


function sortDataBy($arr, $key)
{
    $collection = collect($arr);
    $sorted = $collection->sortBy($key);
    return $sorted;
}

// show date as format: 2020年11月15日 (水) 4:23
if (!function_exists('showDateJP')) {
    function showDateJP($date)
    {
        $date_format = Carbon\Carbon::parse($date)->locale('ja_JA')->isoFormat('ll');
        $dayName = ' (' . Carbon\Carbon::parse($date)->locale('ja_JA')->minDayName . ') ';
        $hour = Carbon\Carbon::parse($date)->locale('ja_JA')->format('H:i');
        return $date_format . $dayName . $hour;
    }
}
// show date as format: 2020年11月15日 (水)
if (!function_exists('showDateJapan')) {
    function showDateJapan($date)
    {
        $date_format = Carbon\Carbon::parse($date)->locale('ja_JA')->isoFormat('ll');
        $dayName = ' (' . Carbon\Carbon::parse($date)->locale('ja_JA')->minDayName . ') ';
        return $date_format . $dayName;
    }
}

if (!function_exists('getStudent')) {

    function getStudent()
    {
        $schoolId = Session::get('school_id');
        $school = \App\Models\School::find($schoolId);
        $studentSchool = $school->student;

        $parents = Auth::guard('parents')->user();
        $studentParents = $parents->student->unique();

        //Check student get by school_id and student get by user login
        return checkStudentOfParents($studentParents, $studentSchool);
    }
}

if (!function_exists('checkStudentOfParents')) {

    function checkStudentOfParents($studentParents, $studentSchool)
    {
        $studentDupes = collect([]);
        $studentParents->each(function ($item) use ($studentSchool, $studentDupes) {
            if ($studentSchool->contains($item) !== false) {
                $studentDupes->push($item);
            }
        });
        return $studentDupes;
    }
}

function getSchool()
{
    $schoolId = Session::get('school_id');
    if ($schoolId) {
        return \App\Models\School::find($schoolId);
    }
    return redirect()->route('front.school.choose')->send();

}

function getSchoolName()
{
    $school = getSchool();
    if ($school) {
        return isset($school->name) ? $school->name : '';
    }
    return '';
}

// get all date of week
if (!function_exists('getCurrentWeekDates')) {
    function getCurrentWeekDates($date)
    {
        $arr = [];
        if (!is_numeric($date))
            $date = strtotime($date);
        if (date('w', $date) == 1)
            $date = $date;
        else
            $date = strtotime('last monday', $date);

        $date = date('Y-m-d', $date);
        $arr[] = $date;
        for ($i = 1; $i <= 6; $i++) {
            $next_date = date('Y-m-d', strtotime($date . ' +1 day'));
            $date = $next_date;
            $arr[] = $next_date;
        }
        return $arr;
    }

}

if (!function_exists('getProductStatus')) {

    function getProductStatus($id = null)
    {
        $arr = [
            1 => '新品、未使用',
            2 => '未使用に近い',
            3 => '目立った傷や汚れあり',
            4 => 'やや傷や汚れあり',
            5 => '傷や汚れあり',
            6 => '全体的に状態が悪い"'
        ];
        if (!$id) {
            return $arr;
        }
        if (!isset($arr[$id])) {
            return '';
        }
        return $arr[$id];
    }
}
if (!function_exists('getListHour')) {
    function getListHour()
    {
        $list = [];
        for ($i = 8; $i <= 20; $i++) {
            for ($j = 0; $j < 60; $j += 15) {
                $list[] = sprintf("%02d", $i) . ':' . sprintf("%02d", $j);
            }
        }
        return $list;
    }
}
if (!function_exists('getListDate')) {
    function getListDate()
    {
        $date = date('Y-m-d');
        $arr[] = $date;
        for ($i = 1; $i <= 300; $i++) {
            $next_date = date('Y-m-d', strtotime($date . ' +1 day'));
            $date = $next_date;
            $arr[] = $next_date;
        }
        return $arr;
    }
}
if (!function_exists('rotate_image')) {
    function rotate_image($img_path)
    {
//        return $img_path;
//        $img_path = 'http://103.130.212.72/hsp-admin/public/storage/uploads/recycle_products/7/images/ualWwY2cdnVOK2Nogws20aXuVIKNbYqaIURW3TDb.jpeg';
        $image = imagecreatefromstring(file_get_contents($img_path));
        $exif = @exif_read_data($img_path, 0, true);
        if (isset($exif['IFD0']['Orientation'])) {
            switch ($exif['IFD0']['Orientation']) {
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
            }
        }
        return \Intervention\Image\Facades\Image::make($image)->encode('data-url');
    }
}