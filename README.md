



create div in html with attr

	class="js_google_recaptcha_item"
	id="your_random_unique_ID"
	data-callback="yourCallbackFunc"
	data-size="invisible"






$options = array(
    'hideBadge' => false,
    'dataBadge' => 'bottomright',
    'timeout'   => 5,
    'debug'     => false
);



$captcha = new Riddman\MultiRecaptcha\Recaptcha(CAPTCHA_SITE_KEY, CAPTCHA_SECRET_KEY, $options);




    yourCallbackFunc = function() {

        // your code
	};



echo captcha()->multiCaptchaRender();



$captcha->verifyResponse($_POST['g-recaptcha-response'], '');