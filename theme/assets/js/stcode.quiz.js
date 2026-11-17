/**
 * Sistema QUIZ [cartão]
 *
 * @author Sarthemes <contato@sarthemes.com>
 * @link https://sarthemes.com
 * @copyright 2024
 */
 
var totalScore = 1,
    questionNumber = 0,
    consts = [],
    self = this;

    this.data = {
        HTML: {
            quiz: '<div class="maker-boxed-progress-bar boxed" style="background: linear-gradient(90deg, #28e2cc #{progress}, #CACACC 0%);"></div><div id="main-content" class="flex flex-col self-center w-full h-full mb-4"><div class="flex flex-col "><h1 class="w-full m-0 mb-3 text-xl font-extrabold leading-none leading-tight text-black md:text-2xl md:text-2xl font-opensans">#{title}</h1><div class="flex flex-row w-full gap-8"><p class="self-center w-full text-sm leading-normal text-justify md:text-left md:text-1x1">#{text}<span class="block pt-2 font-bold text-left text-grey-light text-small">#{text2}</span></p></div></div><div class="relative flex flex-col w-full mt-2 sm:mt-4"><div class="z-10 flex-1 w-full p-4 rounded-lg"><div id="question-#{i}">#{questions}</div><div class="mt-4">#{prev}</div></div></div></div><div class="next-question">#{count}</div>',
            result: '<div class="maker-boxed-progress-bar boxed" style="background: linear-gradient(90deg, #28e2cc #{progress}, #CACACC 0%);"></div><div class="flex flex-col self-center w-full h-full mb-4"><div class="quiz_head_abt"><h1 class="mb-2 text-1xl leading-none font-extrabold md:text-1x4 md:mb-3 text-color-green">#{title}</h1><p class="mb-1 text-base font-bold leading-normal md:w-3/4 md:text-2xl text-green-light">#{text}</p><p class="mb-4 text-1 leading-normal md:w-3/4 md:text-1x1 md:mb-8">#{text2}</p></div><div class="quiz_maker-section-result-form flex items-center gap-10"><div class="quiz_maker-section-result-image -top"><img src="#{icon}" class="quiz_maker-brand-image"></div>#{form}</div></div>'
        },
        REGEX: {
            title: /\#\{title\}/g,
            icon: /\#\{icon\}/g,
            text: /\#\{text\}/g,
            text2: /\#\{text2\}/g,
            form: /\#\{form\}/g,
            questions: /\#\{questions\}/g,
            number: /\#\{i\}/g,
            progress: /\#\{progress\}/g,
            count: /\#\{count\}/g,
            prev: /\#\{prev\}/g
        }
    };

    this.quiz_options = {
        quiz: {
            title: INFQ.quiz_title,
            desc: INFQ.quiz_desc,
            sub_desc: INFQ.quiz_mindesc,
            icon_svg: INFQ.quiz_image
        },
        result: {
            title: INFQ.result_title,
            desc: INFQ.result_desc,
            sub_desc: INFQ.result_mindesc,
            icon_svg: INFQ.result_image
        }
    }

    this.callback = {

        o: function(object) {
            var length = 0;
            for( var key in object ) {
                if( object.hasOwnProperty(key) ) {
                    ++length;
                }
            }
            return length-1;
        },

        n: function(num, places) {
          var zero = places - num.toString().length + 1;
          return Array(+(zero > 0 && zero)).join("0") + num;
        },

        h: function(i){
            var s = allQuestions[0]['question'+i];
            return s;
        },

        b: function(i,type) 
        {
            var s = self.callback.h(i),
            h = '';
            if (type == 'title') {
                h += '<h2 class="text-xl font-bold leading-tight text-black md:text-2xl">'+s.title+'</h2>';
            } else if (type == 'form') {
                h += '<div class="w-full md:w-2/3 md:self-center">';
                h += '<div class="relative name">';
                h += '<label for="nome" class="quiz_maker-label">';
                h += '<span class="quiz_maker-label-content">Nome</span>';
                h += '<input type="text" id="nome" name="name" placeholder="Digite seu nome" validate="name" required="required" tabindex="" max="255" class="quiz_maker-input-form quiz_maker-custom-input">';
                h += '<span class="quiz_maker-error" style="display: none;">Ops, nome inválido. Tente novamente. 🙂</span>';
                h += '</label>';
                h += '</div>';
                h += '<div class="mail">';
                h += '<label for="email" class="quiz_maker-label">';
                h += '<span class="quiz_maker-label-content">E-mail</span>';
                h += '<input type="email" id="e_mail" name="email" data-cy="form-input-2" placeholder="Digite o e-mail" validate="email" required="required" tabindex="" max="255" class="quiz_maker-input-form quiz_maker-custom-input">';
                h += '<span class="quiz_maker-error" style="display: none;">Ops, e-mail inválido. Tente novamente. 🙂</span>';
                h += '</label>';
                h += '</div>';
                h += '<div class="quiz_maker-field quiz_maker-checkbox-field">';
                h += '<label data-cy="form-terms" for="terms" class="quiz_maker-label">';
                h += '<input type="checkbox" name="terms" id="terms" required="required" class="maker-input-checkbox quiz_maker-input-form" value="">';
                h += '<div class="quiz_maker-label-wrapper">';
                h += '<span class="quiz_maker-label-content -custom-checkbox">Li e concordo com os <a class="maker-anchor-link" style="color: black;" title="Termos de Serviço" rel="noopener" href="javascript:void(0)">termos de serviço</a> e aceito receber comunicações da Monify, que poderão ser canceladas a qualquer momento.<div style="display: none; background: var(--gray-100); max-height: 200px; margin-top: 1rem; margin-bottom: 0.5rem; overflow: auto; border: 1px solid var(--gray-500); border-radius: 4px; padding: 2px 6px;"></div></span>';
                h += '<span class="quiz_maker-error" style="display: none;">Você precisa concordar para prosseguir</span></div></label></div>';
                h += '<button data-cy="form-submit" type="submit" class="quiz_maker-quiz-button -cta">';
                h += '<span id="buttonStatus"><p>'+INFQ.button_name+'</p></span>';
                h += '<svg id="spinner" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve" class="quiz_maker-spinner quiz_maker-icon"><path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"></animateTransform></path></svg>';
                h += '<svg id="checkmark" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="quiz_maker-checkmark quiz_maker-icon"><path d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"></path></svg>';
                h += '</button>';
                h += '</div>';
            } else {
                var c = '<div class="flex flex-col flex-wrap justify-between mt-4">',
                l = '',
                j = {};
                for (l, j, u = 0; s.answers.length > u; u++) {
                    m = s.answers[u];
                    c += '<input aria-checked="false" name="question'+i+'" id="question-'+i+'-'+u+'" class="custom-radiobutton ember-view" type="radio" value="'+m+'"><label for="question-'+i+'-'+u+'" class="flex items-center content-center px-4 py-4 mt-3 bg-white rounded-lg cursor-pointer custom-shadow-variant lg:hover:bg-green-light lg:hover:text-black active:bg-green-light active:text-black"><div class="text-green-light"><svg className="svg" fill="currentColor" preserveAspectRatio="xMidYMid meet" height="20" width="20" viewBox="0 0 20 20"><circle className="radioOutline" cx="10" cy="10" r="8" fill="none" stroke="currentColor" strokeWidth="2"></circle></svg></div><span class="flex-1 ml-1 text-sm font-semibold text-left">'+m+'</span></label>';
                }
                h += c;
                h += '</div>';
            }
            return h;
        },

        p: function(porcent,total) {
            var l = '',
            HTML = '';

            if (porcent > 0) {
                l = porcent+'%';
            } else {
                l = '0%';
            }

            HTML = l;

            return HTML;
        },

        changeQuestion: function(i,item,array) {
            totalScore++;
            questionNumber++;
            var r = '',
            total = self.callback.o(allQuestions[0]),
            por = ((i + 1) / total) * 100,
            whatToPut = '<button class="back-answer flex" type="button"><img class="feather feather-grey" src="'+INFQ.URI+'/assets/fonts/boxicons/svg/solid/bxs-chevron-left.svg"> <span>Voltar</span></button>',
            updatePage = ['<strong class="text-lg font-extrabold text-green-light">'+self.callback.n(totalScore,2)+'</strong>/'+self.callback.n(total,2)],
            whereToPut = updatePage[0].length -6;

            if(totalScore < total){
                updatePage = [updatePage.slice(0, whereToPut), '', updatePage.slice(whereToPut)].join('');

                r = item.replace(self.data.REGEX.count, updatePage)
                .replace(self.data.REGEX.prev, whatToPut)
                .replace(self.data.REGEX.progress, por+'%')
                .replace(self.data.REGEX.questions, self.callback.b(questionNumber,'title')+self.callback.b(questionNumber));

                $('#contentQuiz').html(r);

                question(questionNumber);
            } else {
                r = self.data.HTML.result
                .replace(self.data.REGEX.title, self.quiz_options.result.title)
                .replace(self.data.REGEX.text, self.quiz_options.result.desc)
                .replace(self.data.REGEX.text2, self.quiz_options.result.sub_desc)
                .replace(self.data.REGEX.icon, self.quiz_options.result.icon_svg)
                .replace(self.data.REGEX.progress, '100%')
                .replace(self.data.REGEX.form, self.callback.b(questionNumber,'form'));;

                $('#contentQuiz').html(r);

                self.callback.sendForm(array);
            }

            $('#question-'+i).fadeIn("slow");
        },

        backQuestion: function(i,item,array) {
            totalScore--;
            questionNumber--;
            var r = '',
            total = self.callback.o(allQuestions[0]),
            por = ((i - 1) / total) * 100,
            whatToPut = '<button class="back-answer flex" type="button"><img class="feather feather-grey" src="'+INFQ.URI+'/assets/fonts/boxicons/svg/solid/bxs-chevron-left.svg"> <span>Voltar</span></button>',
            updatePage = ['<strong class="text-lg font-extrabold text-green-light">'+self.callback.n(totalScore,2)+'</strong>/'+self.callback.n(total,2)],
            whereToPut = updatePage[0].length -6;

           updatePage = [updatePage.slice(0, whereToPut), '', updatePage.slice(whereToPut)].join('');

            r = item.replace(self.data.REGEX.count, updatePage)
            .replace(self.data.REGEX.prev, whatToPut)
            .replace(self.data.REGEX.progress, por+'%')
            .replace(self.data.REGEX.questions, self.callback.b(questionNumber,'title')+self.callback.b(questionNumber));

            $('#contentQuiz').html(r);

            question(questionNumber);

            restorePreviousAnswer(questionNumber);

            $('#question-'+i).fadeIn("slow");
        },

        v: function(i,item) {
            var total = self.callback.o(allQuestions[0]),
            updatePage = ['<strong class="text-lg font-extrabold text-green-light">'+self.callback.n(1,2)+'</strong>/'+self.callback.n(total,2)],
            whereToPut = updatePage[0].length -6,
            whatToPut = '<button type="button"></button>'

            updatePage = [updatePage.slice(0, whereToPut), '', updatePage.slice(whereToPut)].join('');

            return item.replace(self.data.REGEX.count, updatePage)
            .replace(self.data.REGEX.prev, whatToPut)
            .replace(self.data.REGEX.progress, self.callback.p(i,total))
            .replace(self.data.REGEX.questions, self.callback.b(i,'title')+self.callback.b(i));
        },

        isValidEmailAddress: function(emailAddress) {
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            return pattern.test(emailAddress);
        },

        isNameValid: function(e) {
            return (e.length > 3)
        },

        sendForm: function(selects)
        {
            $(".quiz_maker-quiz-button").click(function(event) {
                event.preventDefault();
                var name = document.getElementById('nome'),
                mail = document.getElementById('e_mail'),
                valid = true;

                if( !self.callback.isValidEmailAddress( mail.value ) ) {
                    valid = false;
                    $( ".mail .quiz_maker-error" ).css('display', 'inline-block');
                }

                if (!self.callback.isNameValid( name.value )) {
                    valid = false;
                    $(".name .quiz_maker-error").css('display', 'inline-block');
                }

                if (!$('#terms').is(':checked')){
                    valid = false;
                    $(".quiz_maker-label-wrapper .quiz_maker-error").css('display', 'inline-block');
                }

                if (valid) {
                    $(this).find('#buttonStatus').hide();
                    $(this).find('.quiz_maker-spinner').show();
                    $.ajax({
                        url: INFQ.ajaxurl,
                        type: "POST",
                        data: {
                            'action': 'send_cliente_quiz',
                            'id': INFQ.quiz,
                            'name': name.value,
                            'email': mail.value,
                            'nonce': INFQ.nonce,
                            'quiz': JSON.stringify(selects)
                        },
                        dataType:"json",
                        success: function(response) {
                            if (response.success) {
                                if (INFQ.postlink)
                                    window.location.href = INFQ.postlink;

                                $(this).find('.quiz_maker-spinner').hide();
                                $(this).find('.quiz_maker-checkmark').show();
                            }
                        },
                        error: function() {
                            return;
                        }
                    });
                }
            });
        },
    }

    // Estrutura de dados para armazenar as respostas selecionadas pelo usuário
    var userAnswers = [];

    // Função para atualizar o registro de respostas com a resposta selecionada pelo usuário
    function updateAnswers(questionIndex, answer) {
        userAnswers[questionIndex] = answer;
    }

    // Função para restaurar a resposta selecionada pelo usuário para a pergunta anterior
    function restorePreviousAnswer(questionIndex) {
        var previousAnswer = userAnswers[questionIndex];
        if (previousAnswer) {
            // Marcar o input radio correspondente à resposta selecionada anteriormente
            $('input[name="question' + questionIndex + '"][value="' + previousAnswer + '"]').prop('checked', true);
        }
    }

    function question(i) {
        $('#question-'+i).fadeOut("slow");
        var total = self.callback.o(allQuestions[0]),
        w = self.data.HTML.quiz
        .replace(self.data.REGEX.title, self.quiz_options.quiz.title)
        .replace(self.data.REGEX.text, self.quiz_options.quiz.desc)
        .replace(self.data.REGEX.text2, self.quiz_options.quiz.sub_desc)
        .replace(self.data.REGEX.icon, self.quiz_options.quiz.icon_svg)
        .replace(self.data.REGEX.number, i),
        r = w;
        if (i == 0) {
            r = self.callback.v(i,r);
            $('#contentQuiz').html(r);
        }

        // Função para lidar com o clique no botão de voltar
        $('.back-answer').on('click', function() {
            if (i > 0) {
                const v = userAnswers[i];
                self.callback.backQuestion(i, w, v);
            }
        });

        // Evento de mudança para os inputs radio
        $("input:radio").on("change", function(){
            var selectedAnswer = $(this).val();
            var currentQuestionIndex = questionNumber;
            updateAnswers(currentQuestionIndex, selectedAnswer); // Atualizar registro de respostas
            var s = self.callback.h(currentQuestionIndex);
            consts.push({
                title: s.title,
                answer: selectedAnswer
            });
            self.callback.changeQuestion(currentQuestionIndex, w, consts);
        });

        $('#question-'+i).fadeIn("slow");
    }

    question(questionNumber);