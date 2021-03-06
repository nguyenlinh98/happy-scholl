<?php

return [
    'option_functions' => [
        'letter' => [
            'column' => 'letter_active',
            'text' => 'お手紙',
        ],
        'letter_individual' => [
            'column' => 'letter_individual_active',
            'text' => '個別お手紙',
        ],
        'message' => [
            'column' => 'message_active',
            'text' => 'お知らせ',
        ],
        'require_feedback' => [
            'column' => 'require_feedback_active',
            'text' => '回答必要通知',
        ],
        'recycle' => [
            'column' => 'recycle_active',
            'text' => 'リサイクル',
        ],
        // 'happy_school_plus' => [
        //     'column' => 'happy_school_plus_active',
        //     'text' => 'ハピスクタウン',
        // ],
        'contact_book' => [
            'column' => 'contact_book_active',
            'text' => '連絡網',
        ],
        'urgent_contact' => [
            'column' => 'urgent_contact_active',
            'text' => '緊急連絡',
        ],
        'calendar' => [
            'column' => 'calendar_active',
            'text' => 'カレンダー',
        ],
        'seminar' => [
            'column' => 'seminar_active',
            'text' => '講座',
        ],
        'event' => [
            'column' => 'event_active',
            'text' => 'イベント',
        ],
    ],
    'topadmin_sidebar_menus' => [
        'home' => [
            'changable' => false,
            'column' => '',
            'text' => '所属先情報入力・パスコード発行',
            'image' => '',
            'route' => 'top_admin.school.create',
        ],
        'school' => [
            'changable' => false,
            'column' => '',
            'text' => '登録一覧',
            'image' => '',
            'route' => 'top_admin.school.index',
        ],
        'setting' => [
            'changable' => false,
            'column' => '',
            'text' => '編集・設定（パスワードの変更など）',
            'image' => '',
            'route' => 'top_admin.setting.index',
        ],
        'calendar' => [
            'changable' => false,
            'column' => '',
            'text' => 'カレンダー（祝日の設定）',
            'image' => '',
            'route' => 'top_admin.calendar.index',
        ],
    ],
    'sidebar_menus' => [
        'home' => [
            'changable' => false,
            'column' => '',
            'text' => 'ホーム画面',
            'image' => 'home.png',
            'image-hover' => 'home.png',
            'route' => 'home',
        ],
        'letter' => [
            'changable' => true,
            'column' => 'letter_active',
            'text' => 'お手紙',
            'image' => 'letter.png',
            'image-hover' => 'letter.png',
            'title' => 'お手紙',
            'route' => 'admin.letter.index',
        ],
        'message' => [
            'changable' => true,
            'column' => 'message_active',
            'text' => 'お知らせ',
            'image' => 'message.png',
            'image-hover' => 'message.png',
            'title' => 'お知らせ',
            'route' => 'admin.message.sent_list',
        ],
        'require_feedback' => [
            'changable' => true,
            'column' => 'require_feedback_active',
            'text' => '回答必要通知',
            'image' => 'require_feedback.png',
            'image-hover' => 'require_feedback.png',
            'title' => '回答必要通知',
            'route' => 'admin.require_feedback.index',
        ],
        'contacts' => [
            'changable' => true,
            'column' => 'contact_book_active',
            'text' => '連絡網',
            'image' => 'contact.png',
            'image-hover' => 'contact.png',
            'title' => '連絡網',
            'route' => 'admin.contact.index',
        ],
        'urgent_contact' => [
            'changable' => true,
            'column' => 'urgent_contact_active',
            'text' => '緊急連絡(開発中)',
            'image' => 'home.png',
            'image-hover' => 'home.png',
            'route' => 'admin.urgent_contact.index'
        ],
        'calendar' => [
            'changable' => true,
            'column' => 'calendar_active',
            'text' => 'カレンダー',
            'image' => 'calendar.png',
            'image-hover' => 'calendar.png',
            'route' => 'admin.calendar.index',
        ],
        'class' => [
            'changable' => false,
            'text' => 'クラス一覧',
            'image' => 'class.png',
            'image-hover' => 'class.png',
            'route' => 'admin.class.index',
        ],
        'cgroup' => [
            'changable' => false,
            'column' => '',
            'text' => 'クラスグループ設定',
            'image' => 'class-group.png',
            'image-hover' => 'class-group.png',
            'title' => 'クラスグループ設定',
            'route' => 'admin.cgroup.create',
        ],
        'recycle' => [
            'changable' => true,
            'column' => 'recycle_active',
            'text' => 'リサイクル',
            'image' => 'recycle.png',
            'image-hover' => 'recycle.png',
            'route' => 'admin.recycle.index',
        ],
        'student_setting' => [
            'changable' => false,
            'column' => '',
            'text' => '生徒登録設定（転入・転校）',
            'image' => 'register-student.png',
            'image-hover' => 'register-student.png',
            'title' => '生徒一覧',
            'route' => 'admin.student_setting.index',
        ],
        'seminar' => [
            'changable' => true,
            'column' => 'seminar_active',
            'text' => '講座(開発中)',
            'image' => 'seminar.png',
            'image-hover' => 'seminar.png',
            'title' => '講座配信予約一覧',
            'route' => 'admin.seminar.index',
        ],
        'event' => [
            'changable' => true,
            'column' => 'event_active',
            'image-hover' => 'event.png',
            'text' => 'イベント(開発中)',
            'image' => 'event.png',
            'route' => 'admin.school_event.index'
        ],
        'admin_setting' => [
            'changable' => false,
            'column' => '',
            'text' => '管理者登録設定',
            'image' => 'register-admin.png',
            'image-hover' => 'register-admin.png',
            'route' => 'admin.teacher.create',
        ],
        'department_setting' => [
            'changable' => false,
            'column' => '',
            'text' => '所属先設定',
            'image' => 'home.png',
            'image-hover' => 'home.png',
            'route' => 'admin.department_setting.index',
        ],
        // 'corporate' => [
        //     'changable' => false,
        //     'column' => '',
        //     'text' => '業者登録',
        //     'image' => 'corporate.png',
        //     'route' => 'corporate.index',
        // ],
        'school_setting' => [
            'changable' => false,
            'column' => '',
            'text' => '学校設定',
            'image' => 'school.png',
            'image-hover' => 'school.png',
            'route' => 'admin.school_setting.index',
        ],
        'year_close' => [
            'changable' => false,
            'column' => '',
            'text' => '年度終了ボタン',
            'image' => 'year.png',
            'image-hover' => 'year.png',
            'route' => 'admin.year_close.index',
        ],
    ],
    'prefectures' => [
        '' => '',
        '北海道' => '北海道',
        '青森県' => '青森県',
        '岩手県' => '岩手県',
        '宮城県' => '宮城県',
        '秋田県' => '秋田県',
        '山形県' => '山形県',
        '福島県' => '福島県',
        '茨城県' => '茨城県',
        '栃木県' => '栃木県',
        '群馬県' => '群馬県',
        '埼玉県' => '埼玉県',
        '千葉県' => '千葉県',
        '東京都' => '東京都',
        '神奈川県' => '神奈川県',
        '新潟県' => '新潟県',
        '富山県' => '富山県',
        '石川県' => '石川県',
        '福井県' => '福井県',
        '山梨県' => '山梨県',
        '長野県' => '長野県',
        '岐阜県' => '岐阜県',
        '静岡県' => '静岡県',
        '愛知県' => '愛知県',
        '三重県' => '三重県',
        '滋賀県' => '滋賀県',
        '京都府' => '京都府',
        '大阪府' => '大阪府',
        '兵庫県' => '兵庫県',
        '奈良県' => '奈良県',
        '和歌山県' => '和歌山県',
        '鳥取県' => '鳥取県',
        '島根県' => '島根県',
        '岡山県' => '岡山県',
        '広島県' => '広島県',
        '山口県' => '山口県',
        '徳島県' => '徳島県',
        '香川県' => '香川県',
        '愛媛県' => '愛媛県',
        '高知県' => '高知県',
        '福岡県' => '福岡県',
        '佐賀県' => '佐賀県',
        '長崎県' => '長崎県',
        '熊本県' => '熊本県',
        '大分県' => '大分県',
        '宮崎県' => '宮崎県',
        '鹿児島県' => '鹿児島県',
        '沖縄県' => '沖縄県',
    ],
    'event_user' => [
        'event_color' => [
            '#F097BE',
            '#81CFF4',
            '#EDA800',
            '#B1514E',
            '#CC8C8A',
        ],
        'event_remind' => [
            '0' => '0 分前',
            '5' => '5 分前',
            '15' => '15 分前',
            '30' => '30 分前',
            '60' => '1 時間前',
            '720' => '12 時間前',
        ],
    ],

    'schools_color' => [
        'event_color' => '#F097BE',
        'seminar_color' => '#81CFF4'
    ],
    'seminar_relationship' => [
        '父' => '父',
        '母' => '母',
        '叔父' => '叔父',
        '叔母' => '叔母',
        '祖父' => '祖父',
        '祖母' => '祖母',
        'その他' => 'その他',
    ]
];
