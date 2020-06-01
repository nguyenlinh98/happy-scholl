<?php
/**
 * User: JohnAVu
 * Date: 2019-12-30
 * Time: 09:51
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class LetterController extends Controller
{
    const FAVORITE = 'favorite'; // receiver_type = 1
    const RECYCLE = 'recycle';

    public function index($student_id, $status = null)
    {
        Log::info('[LetterController.index] Start...');
        if ($status == self::FAVORITE) {
            $letters = Letter::getLetterFavorite($student_id);
            Log::info('[LetterController.index] End...');
            return view('front.letters.favorite', compact('letters','student_id'));
        }
        elseif ($status == self::RECYCLE) {
            $letters = Letter::getLetterTrash($student_id);
            Log::info('[LetterController.index] End...');
            return view('front.letters.recycle', compact('letters','student_id'));
        }
        else {
            $letters = Letter::getLetterAll($student_id);
//            dd($letters);
            Log::info('[LetterController.index] End...');
            return view('front.letters.index', compact('letters','student_id'));
        }
    }

    public function view($student_id,$id)
    {
        Log::info('[LetterController.view] Start...');
        $letter = Letter::viewLetterDetail($student_id, $id);
        if(Route::getCurrentRoute()->getActionMethod() == 'view') {
            $statusLetterRead = Letter::checkLetterRead($id, $student_id);
            if($statusLetterRead) {
                if(count($statusLetterRead->toArray()) > 0) Letter::updateLetterRead($statusLetterRead['id']);
            }
        }
        Log::info('[LetterController.view] End...');
        return view('front.letters.view', compact('letter'));
    }

    public function updateLetterType(Request $request)
    {
        Log::info('[LetterController.updateLetterType] Start...');
        $receiver_type = $request['type'];
        $receiver_id = $request['id'];
        if($receiver_type == 1) {
            $receiver_type_update = 0;
        } else {
            $receiver_type_update = 1;
        }
        Letter::updateLetterType($receiver_id, $receiver_type_update);
        Log::info('[LetterController.updateLetterType] End...');
        return response()->json(['receiver_type_update' => $receiver_type_update]);
    }

    public function removeLetterFavorite(Request $request)
    {
        Log::info('[LetterController.removeLetterFavorite] Start...');
        $id = $request['id'];
        Letter::removeLetterFavorite($id);
        Log::info('[LetterController.removeLetterFavorite] End...');
        return response()->json(['ok' => 'ok']);
    }

    public function deleteOneLetter(Request $request)
    {
        Log::info('[LetterController.deleteOneLetter] Start...');
        $id = $request['id'];
        Letter::deleteOneLetter($id);
        Log::info('[LetterController.deleteOneLetter] End...');
        return response()->json(['ok' => 'ok']);
    }

    public function removeLetterTrash(Request $request)
    {
        Log::info('[LetterController.removeLetterTrash] Start...');
        $id = $request['id']; $student_id = $request['student_id'];
        Letter::removeLetterTrash($id, $student_id);
        Log::info('[LetterController.removeLetterTrash] End...');
        return response()->json(['ok' => 'ok']);
    }
}
