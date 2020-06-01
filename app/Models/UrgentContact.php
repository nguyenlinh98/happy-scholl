<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\UrgentContactReceiver;
use App\Models\UrgentContactDetailStatus;
use App\Http\Requests\CreateUrgentContact as CreateUrgentRequest;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\HasReceiverTrait;
use App\Traits\Models\SchoolScopeTrait;
use Arr;

class UrgentContact extends Model
{
    use SoftDeletes;
    use LocalizeDateTimeTrait;
    use HasReceiverTrait;
    use SchoolScopeTrait;

    //const STATUS_CREATED = 0;
    //const STATUS_SENT = 1;
    const YESNO = 'YN';
    const INPUT = 'IN';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $polarQuestions;

    protected $whQuestions;
    /**
     * Initialize default questionnaire.
     */
    public static function getInstanceWithQuestions($polarQuestions = null, $whQuestions = null)
    {
        $urgentContact = new static;

        $urgentContact->polarQuestions =
                        (is_array($polarQuestions) ? $polarQuestions
                        : ! is_null($polarQuestions)) ? [$polarQuestions]
                        : [
                            'YN1' => 'お子様とご一緒にいますか？',
                            'YN2' => 'お怪我はございませんか？',
                            'YN3' => '今、安全な場所にいますか？',
                            'YN4' => 'ご自宅は無事ですが？',
                            'YN5' => 'ご家族全員の安否は確認できていますか？',
                            'YN6' => '指定の避難所の場所はわかりますか？',
                        ];

        $urgentContact->whQuestions =
                        (is_array($whQuestions) ? $whQuestions
                        : ! is_null($whQuestions)) ? [$whQuestions]
                        : [
                            'IN1' => '今どこにいますか？',
                            'IN2' => 'お困りごとはございますか？',
                            'IN3' => 'いつから登校できますか？',
                        ];

        return $urgentContact;
    }

    /**
     * Accessors for default questions.
     */
    public function getGeneralQuestionsAttribute()
    {
        return $this->polarQuestions;
    }

    public function getSpecialQuestionsAttribute()
    {
        return $this->whQuestions;
    }

    /**
     * Depict this model's relationships.
     */
    public function receivers()
    {
        return $this->hasMany(UrgentContactReceiver::class, 'urgent_contact_id');
    }

    public function readStatuses()
    {
        return $this->hasMany(UrgentContactDetailStatus::class, 'urgent_contact_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }

    /**
     * Utitity functions for issuing a urgent contact.
     */

    public  static function prepareForReview(CreateUrgentRequest $request)
    {
        $urgentContact = ! (isset($this) && is_a($this, __CLASS__))
                            ? new static() : $this;

        $urgentContact->subject = $request->input('subject');

        $urgentContact->sender = $request->input('sender');

        $urgentContact->yesNoQuestions = $request->input('yn_questions');

        $urgentContact->inputQuestions = $request->input('in_questions');

        $urgentContact->sendAll = 'on' === $request->input('send_all') ? true : false;

        $urgentContact->schoolClasses = $urgentContact->getSchoolClassById($request);

        return $urgentContact;
    }

    private function getSchoolClassById($request)
    {
        return SchoolClass::find(array_keys($request->input('school_classes')))
                                            ->pluck('name', 'id')->toArray();
    }

    public static function makeInstanceWithQuestions(CreateUrgentRequest $request)
    {
        $urgentContact = static::create([
            'subject' => $request->subject,
            'sender' => $request->sender,
        ]);

        // Need merge all questions into genaral one for running job later on, then save the questions to database.
        $urgentContact->questionnaire = $request->input('yn_questions') + $request->input('in_questions');

        $urgentContact->sendAll = 'on' === $request->input('send_all') ? true : false;

        $urgentContact->schoolClasses = $urgentContact->getSchoolClassById($request);

        $urgentContact->receiversSync(SchoolClass::class, array_keys($urgentContact->schoolClasses), 'receivers', 'urgent_contact_id');

        return $urgentContact;
    }
}
