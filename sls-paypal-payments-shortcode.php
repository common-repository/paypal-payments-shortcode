<?php
/*
	Plugin Name: Paypal Payment Shortcode Multi
	Description: Usage with Shortcode to Create Multiple PayPal Payment Widget
	Author: Son Lam
	Author URI: http://www.thietkewebre.org/
	Version:1.01
*/
add_shortcode('paypal-shortcode','sls_paypal_payment_shortcode');
function sls_paypal_payment_shortcode($args){
	extract(shortcode_atts(array(
		'email' => '',	
		'currency' => 'USD',
        'descriptions'=>'',
		'options' => 'Payment for Service 1:15.50|Payment for Service 2:30.00|Payment for Service 3:47.00',
		'return' => site_url(),
		'reference' => 'Your Email Address',
		'buttom_image' => '',
		'cancel_url' => '',
	),$args));
	$output = "";
	$options = explode( '|' , $options);
	$html_options = '';
	foreach( $options as $option ) {
		$option = explode( ':' , $option );
		$name = esc_attr( $option[0] );
		$price = esc_attr( $option[1] );
		$html_options .= "<option value='{$price}'>{$name}</option>";
	}
    if(!empty($descriptions)){
        $title = $descriptions;
    } 
	$paypal_button_image = "";
	if(!empty($buttom_image)){
		$paypal_button_image = $buttom_image;
	}else{
		$paypal_button_image = "https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif";		
	}
	if(empty($email)){
		$output = '<p style="color: red;">Error! Please enter your PayPal email address for the payment using the "email" parameter in the shortcode</p>';
		return $output;
	}?>
	
<?php
	$output .='<div class="sls_paypal_payment">';
	$output .= '<form class="wp_accept_pp_button_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
	$output .= '<input type="hidden" name="cmd" value="_xclick">';
	$output .=	'<input type="hidden" name="business" value="'.$email.'">';
   /* $output .=	'<input type="hidden" name="hosted_button_id" value="67WH3H6VPXX7E">';*/   
	$output .=	'<input type="hidden" name="item_name" value="'.$title.'">';
	$output .=	'<input type="hidden" name="currency_code" value="'.$currency.'">';
    $output .= '<select class="wp_paypal_button_options" name="amount" >';
	$output .= $html_options;
	$output .= '</select><br/><br/>';
	$output .='<input type="image" id="buy_now_button" src="'.$paypal_button_image.'" border="0" name="submit" alt="Make payments with PayPal">';
    $output .='&nbsp;&nbsp;&nbsp;<img src="http://adorecambodia.org/preview/wp-content/uploads/2014/01/donate-btt1.png" width="147"/>';
	$output .='</form>';
	$output .='</div>';
	return $output;
}
?>