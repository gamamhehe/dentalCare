<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 7/4/2018
 * Time: 9:54 PM
 */
return [
    /** set your paypal credential **/
    'client_id' => 'Adlrxyv1TYdbEKdlmnMAl8Lp5dGzUqbddB36_9S8G9FI1BzBhKYloEc2cPnlfSZjL9qiViqQtgcvrqtt',
    'secret' => 'EAeoSltuYKFfuTxDR6XcQ3HSOSnFf0NpK5Wc3JZSL2gAp94E2ZK63CPmIWFlLlfKtM3Thwrz2w9z_uvL',
    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 10000,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    )
];