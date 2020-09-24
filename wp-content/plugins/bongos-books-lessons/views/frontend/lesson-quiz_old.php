<?php if (!empty($quizes)) :  
$user_login =0;
if ( is_user_logged_in() ) { $user_login =1;
}
$user_sub=0;
 $has_sub = wcs_user_has_subscription( get_current_user_id(), 361, 'active' ); 
 if($has_sub)
 {
    $user_sub=1; 
 }
?>

    <script>
        var quizData = <?= json_encode($quizes); ?>;
        var wrongAnswer = <?= json_encode($wrong_answer_message); ?>;
        var correctAnswer = <?= json_encode($correct_answer_message); ?>;
        var is_login = <?= $user_login; ?>;
       
        var is_sub = <?= $user_sub; ?>;
    </script>

    <div id="lesson-quiz" class="quiz-module">
        <div v-for="question, i in quiz.questions">
            <div v-show="i === questionIndex">
                <h2>Quiz</h2>
                <h4>{{ question._bongos_books_lesson_metabox_quiz_question }}</h4>
                <ol>
                    <li v-for="response, j in question._bongos_books_lesson_metabox_quiz_answers">
                        <label>
                            <input type="radio"
                                   v-bind:value="j"
                                   v-bind:name="i"
                                   v-on:click="selected[i] = true"
                                   v-model="userResponses[i]"> {{response._bongos_books_lesson_metabox_quiz_answer_choice}}
                        </label>
                    </li>
                    <div class="question-response" v-show="selected[i]">{{ getAnswerMessage(question, userResponses[i]) }}</div>
                </ol>
                <button v-if="questionIndex > 0" v-on:click="prev">
                    Previous
                </button>
                <button v-on:click="next">
                    Next
                </button>
            </div>
        </div>
        <div v-show="questionIndex === quiz.questions.length">
            <h2>
                Quiz Complete
            </h2>
            <p>
                Your Score: {{ score() }} / {{ quiz.questions.length }}
            </p>
        </div>
    </div>

<?php endif; ?>