<?php
if (!class_exists('EnvatoApi2')) 
{
    class EnvatoApi2
    {
        // Bearer, no need for OAUTH token, change this to your bearer string
        // https://build.envato.com/api/#token
        private static $bearer = "X6PVbSWXCD9moqGgkRuNEOuxFn1ApyGU";

        static function getPurchaseData($code)
        {

            //setting the header for the rest of the api
            $bearer = 'bearer ' . self::$bearer;
            $header = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json; charset=utf-8';
            $header[] = 'Authorization: ' . $bearer;

            $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $code . '.json';

            $response = wp_remote_get(
                $verify_url . '?code=' . $code,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . self::$bearer,
                        'Content-type' => 'application/json; charset=utf-8',
                        'Access-Control-Allow-Origin'=> "*",
                    ],
                ]
            );

            $body = wp_remote_retrieve_body($response);

            if ($body != "") {
                return json_decode($body);
            } else {
                return false;
            }

        }

        static function verifyPurchase($code)
        {
            $verify_obj = self::getPurchaseData($code);

            // Check for correct verify code
            if (
                (false === $verify_obj) ||
                !is_object($verify_obj) ||
                !isset($verify_obj->{"verify-purchase"}) ||
                !isset($verify_obj->{"verify-purchase"}->item_name)
            )
                return -1;

            // If empty or date present, then it's valid
            if (
                $verify_obj->{"verify-purchase"}->supported_until == "" ||
                $verify_obj->{"verify-purchase"}->supported_until != null
            )
                return $verify_obj->{"verify-purchase"};

            // Null or something non-string value, thus support period over
            return 0;

        }
    }
}

?>