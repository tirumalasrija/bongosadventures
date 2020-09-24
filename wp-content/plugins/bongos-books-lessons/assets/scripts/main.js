import Vue from 'vue';

var quiz = {
    questions: quizData
};

new Vue({
    el: '#lesson-quiz',
    data: {
        quiz: quiz,
        questionIndex: 0,
        selected: [],
        userResponses: Array(quiz.questions.length).fill(false)
    },
    methods: {
        next: function() {
           
            this.questionIndex++;
        },
        prev: function() {
            this.questionIndex--;
        },
        score: function() {
            return this.userResponses.filter(function(val) { return val; }).length;
        },
        getAnswerMessage: function(question, index) {
            var answer = question._bongos_books_lesson_metabox_quiz_answers[index];

            // Check if answer exists and is "correct"
            if (answer && typeof answer._bongos_books_lesson_metabox_quiz_answer_choice_correct !== 'undefined') {

                // Check if there is a message defined
                if(typeof answer._bongos_books_lesson_metabox_quiz_answer_choice_message !== 'undefined') {
                    return answer._bongos_books_lesson_metabox_quiz_answer_choice_message;
                } else {
                    return correctAnswer;
                }
            } else {
                return wrongAnswer;
            }
        }
    }
});