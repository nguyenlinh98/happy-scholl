<?php

namespace Tests\Feature\Letter;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class LetterNotificationStressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $teacher = User::whereHas('role', function ($query) {
            $query->where('name', 'school_admin');
        })->where('school_id', '<>', 0)->first();

        $this->be($teacher, 'schooladmin');

        $this->assertAuthenticated('schooladmin');
        $response = $this->get(route('admin.letter.index'));

        $response->assertStatus(200);

        $uuid = Str::random(5);
        foreach (range(1, 50) as $index) {
            $response = $this->post(route('admin.letter.store'), [
                'subject' => 'stress_test_'.$uuid.'_v'.$index,
                'body' => (bool) random_int(0, 1) ? 'stress_test_'.$uuid.'_v'.$index : '',
                'sender' => 'stress_test_'.$uuid.'_v'.$index,
                'date' => today()->format('Y-m-d'),
                'time' => '00:00',
                'send_to_school_classes' => [
                    '1',
                    '5',
                    '9',
                    ],
                'send_to_select' => 'school_classes',
                'file_path' => null,
                'file_name' => null,
                'letter_type' => 'collection',
            ]);
            $response->assertStatus(302);
        }
    }
}
