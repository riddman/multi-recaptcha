<?php

namespace Riddman\MultiRecaptcha;


class Recaptcha extends \AlbertCht\InvisibleReCaptcha\InvisibleReCaptcha
{



    public function multiCaptchaRender() {

        ob_start();
    ?>
    <script type="text/javascript">
        var recaptchesLIst = {};
        var onloadCallback = function() {
            var list   = $('.js_google_recaptcha_item');
            var length = list.length;

            if (length <= 0)
                return false;

            for (n = 0; n < length; n++  ) {
                var $currentElement = $(list[n]);

                recaptchesLIst[ $currentElement.attr('id') ] = {
                    'form': $currentElement.closest('form'),
                    'render_entity' : null
                }

                $currentElement.closest("form").one('click', function() {
                    var selfElement   = $(this).find('.js_google_recaptcha_item');
                    var dataForRender = {'sitekey' : '<?php echo $this->siteKey; ?>' };

                    if (selfElement.data('theme')) {
                        dataForRender['theme'] = selfElement.data('theme');
                    }

                    if (selfElement.data('type')) {
                        dataForRender['type'] = selfElement.data('type');
                    }

                    if (selfElement.data('tabindex')) {
                        dataForRender['tabindex'] = selfElement.data('tabindex');
                    }

                    if (selfElement.data('size')) {
                        dataForRender['size'] = selfElement.data('size');
                    }

                    if (selfElement.data('callback')) {
                        dataForRender['callback'] = selfElement.data('callback');
                    }
                    else {
                        dataForRender['callback'] = function() {
                            $(item).closest("form").submit();
                        };
                    }

                    recaptchesLIst[ selfElement.attr('id') ]['render_entity'] = grecaptcha.render(
                        selfElement.attr('id'),
                        dataForRender
                    );

                    $(this).closest("form").on('submit', function(e) {
                        e.preventDefault();
                        $(this)
                            .find(".js_google_recaptcha_item [name='g-recaptcha-response']")
                            .text(
                                grecaptcha.execute(recaptchesLIst[ selfElement.attr('id') ]['render_entity'])
                            );
                    });
                });
            }
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <?php


        $recaptchBuffer = ob_get_clean();

        return $recaptchBuffer;
    }

}
// composer require riddman/multi-recaptcha:dev-master