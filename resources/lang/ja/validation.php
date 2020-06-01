<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => '有効なURLではありません。',
    'after'                => ':dateより後の日付を指定してください。',
    'after_or_equal'       => ':date以前の日付を指定してください。',
    'alpha'                => 'アルファベットのみがご利用できます。',
    'alpha_dash'           => 'アルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num'            => 'アルファベット数字がご利用できます。',
    'array'                => ':attributeは配列でなくてはなりません。',
    'before'               => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal'      => ':attributeには、:date以前の日付をご利用ください。',
    'between'              => [
        'numeric' => ':minから:maxの間で指定してください。',
        'file'    => ':min kBから、:max kBの間で指定してください。',
        'string'  => ':min文字から、:max文字の間で指定してください。',
        'array'   => ':min個から:max個の間で指定してください。',
    ],
    'boolean'              => 'trueかfalseを指定してください。',
    'confirmed'            => ':attributeと、確認フィールドとが、一致していません。',
    'date'                 => '有効な日付ではありません',
    'date_format'          => ':format形式で指定してください。',
    'different'            => ':otherには、異なった内容を指定してください。',
    'digits'               => ':digits桁で指定してください。',
    'digits_between'       => ':min桁から:max桁の間で指定してください。',
    'dimensions'           => '図形サイズが正しくありません。',
    'distinct'             => '異なった値を指定してください。',
    'email'                => '有効なメールアドレスではありません。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => 'ファイルを指定してください。',
    'filled'               => '値を指定してください。',
    'image'                => '画像ファイルを指定してください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => ':otherの値を指定してください。',
    'integer'              => '整数で指定してください。',
    'ip'                   => '有効なIPアドレスを指定してください。',
    'ipv4'                 => '有効なIPv4アドレスを指定してください。',
    'ipv6'                 => '有効なIPv6アドレスを指定してください。',
    'json'                 => '有効なJSON文字列を指定してください。',
    'max'                  => [
        'numeric' => ':max以下の数字を指定してください。',
        'file'    => ':max kB以下のファイルを指定してください。',
        'string'  => ':max文字以下で指定してください。',
        'array'   => ':max個以下指定してください。',
    ],
    'mimes'                => ':valuesタイプのファイルを指定してください。',
    'mimetypes'            => ':valuesタイプのファイルを指定してください。',
    'min'                  => [
        'numeric' => ':min以上の数字を指定してください。',
        'file'    => ':min kB以上のファイルを指定してください。',
        'string'  => ':min文字以上で指定してください。',
        'array'   => ':min個以上指定してください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'numeric'              => '数字を指定してください。',
    'present'              => 'データが存在していません。',
    'regex'                => '正しい形式を指定してください。',
    'required'             => '必須項目です',
    'required_if'          => ':otherが:valueの場合、:attributeも指定してください。',
    'required_unless'      => ':otherが:valuesでない場合、:attributeを指定してください。',
    'required_with'        => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_with_all'    => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_without'     => ':valuesを指定しない場合は、:attributeを指定してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを指定してください。',
    'same'                 => ':attributeと:otherには同じ値を指定してください。',
    'size'                 => [
        'numeric' => ':sizeを指定してください。',
        'file'    => 'ファイルは、:sizeキロバイトでなくてはなりません。',
        'string'  => ':size文字で指定してください。',
        'array'   => ':size個指定してください。',
    ],
    'string'               => '文字列を指定してください。',
    'timezone'             => '有効なゾーンを指定してください。',
    'unique'               => '値は既に存在しています。',
    'uploaded'             => 'アップロードに失敗しました。',
    'url'                  => '正しい形式を指定してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'product.images' => 'images',
        'product.name' => 'name',
        'product.detail' => 'detail',
        'product.product_status' => 'product status',
    ],
];
