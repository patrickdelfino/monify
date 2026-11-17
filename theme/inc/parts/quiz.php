<html class="h-full"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no">
<title><?php echo bloginfo('name'); ?> Quiz <?php echo get_the_title($quiz_encontrado); ?></title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo STCODE_URI; ?>/assets/css/stcode.quiz.css">
<meta name="theme-color" content="#ffffff">
<body class="h-full">
    <div id="contentQuiz" class="container flex justify-center mx-auto mt-8"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <?php
    $quiz_meta = stcode_get_all_questions($quiz_encontrado);
    $arr = [];
    foreach ($quiz_meta as $index => $meta) {
        $answers = [];
        if (!empty($meta['answer'])) {
            foreach (unserialize($meta['answer'], ['allowed_classes' => false]) as $answer) {
                $answers[] = $answer;
            }
        }

        $arr['question'.$index] = [
            'title' => $meta['question_title'],
            'answers' => $answers
        ];
    }
    $post_meta = get_post_meta($quiz_encontrado);
    $new_meta = [
        'quiz' => $quiz_encontrado,
        'nonce' => wp_create_nonce('monify-quiz-' . $quiz_encontrado),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'URI' => STCODE_URI,
        'quiz_title' => isset($post_meta['stcode_quiz_title']) ? $post_meta['stcode_quiz_title'] : '',
        'quiz_desc' => isset($post_meta['stcode_quiz_desc']) ? $post_meta['stcode_quiz_desc'] : '',
        'quiz_mindesc' => isset($post_meta['stcode_quiz_mindesc']) ? $post_meta['stcode_quiz_mindesc'] : '',
        'result_title' => isset($post_meta['stcode_result_title']) ? $post_meta['stcode_result_title'] : '',
        'result_desc' => isset($post_meta['stcode_result_desc']) ? $post_meta['stcode_result_desc'] : '',
        'result_mindesc' => isset($post_meta['stcode_result_mindesc']) ? $post_meta['stcode_result_mindesc'] : '',
        'result_image' => isset($post_meta['stcode_result_image']) ? $post_meta['stcode_result_image'] : '',
        'postlink' => isset($post_meta['stcode_post_link']) ? $post_meta['stcode_post_link'] : '',
        'button_name' => isset($post_meta['stcode_button_name']) ? $post_meta['stcode_button_name'] : ''
    ]
    ?>
    <script type="text/javascript">
        /* <![CDATA[ */
        var allQuestions = [<?php echo wp_json_encode($arr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>];
        var INFQ = <?php echo wp_json_encode($new_meta, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
        /* ]]> */
    </script>
    <script type="text/javascript" src="<?php echo STCODE_URI; ?>/assets/js/stcode.quiz.js"></script>
</body>
</html>