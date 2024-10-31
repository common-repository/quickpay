<?php

function qpay_payment_form() {
    echo '
    <style>
        input[type=text], select {
          width: auto;
          padding: 10px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }

        input[type=number], select {
          width: auto;
          padding: 10px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }


        input[type=submit] {
          width: auto;
          background-color: #4CAF50;
          color: white;
          padding: 14px 20px;
          margin-top:15px !important;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          font-family: Arial, Helvetica, sans-serif;
        }

        input[type=submit]:hover {
          background-color: #45a049;
        }

        .form_{
          border-radius: 5px;
          background-color: #f2f2f2;
          padding: 10px;
          width:20%;
        }

        label{
            font-size:14px;
            margin-left:4px;
        }
    </style>
    ';
 
    echo '
    <form action="" method="post">
        <div class="form_">

        <label for="amount">Amount</label><br>

        <input type=number name="amount" id="amount"><br>

        <label for="msisdn">Phone</label><br>

        <input type="text" name="msisdn" id="msisdn" placeholder="2567*******">

        <input type="submit" name="submit" value="Pay Now"/>
        </div>
    </form>
    ';
}


if (isset($_POST['submit'] ) ) { 
        
        // sanitize phone & amount form input
        global $qpay_msisdn,$qpay_amount;
        $qpay_msisdn   =   sanitize_text_field( $_POST['msisdn'] );
        $qpay_amount   =   sanitize_text_field( $_POST['amount'] );
        $key =  get_option( 'quickpay_api_key' );

        $endpoint = 'https://qpapi.bluecube.co.ug/api/v2/payrequest/pay/';


        $body = [
            'amount' => $qpay_amount,
            'fundingsource' => $qpay_msisdn,
            'narration'=>'wp quickpay plugin request'
        ];
         
        $body = wp_json_encode( $body );

        $options = [
            'body'        => $body,
            'headers'     => [
                'Content-Type' => 'application/json',
                'API-KEY'=>$key
            ],
            'timeout'     => 60,
            'redirection' => 5,
            'blocking'    => true,
            'httpversion' => '1.0',
            'sslverify'   => false,
            'data_format' => 'body',
        ];
 
        $response = wp_remote_post($endpoint, 
            $options );
}

//Register a new shortcode: [quick_payment]
add_shortcode( 'quick_payment', 'qpay_payment_shortcode' );
 
//The callback function that will replace [book]
function qpay_payment_shortcode() {
    ob_start();
    qpay_payment_form();
    return ob_get_clean();
}