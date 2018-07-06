<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Key;
use phpseclib\Crypt\RSA;
use App\Model\TreatmentHistory;
use App\Model\NodeInfo;

class BlockchainController extends Controller
{

    public function GenerateKey()
    {
        $patientId = '1'; // query from databse
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        
        // Create the private and public key
        $res = openssl_pkey_new($config);
        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

    // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];
        $data = $patientId;

    // Encrypt the data to $encrypted using the public key
        openssl_public_encrypt($data, $encrypted, $pubKey);

    // Decrypt the data using the private key and store the results in $decrypted
        openssl_private_decrypt($encrypted, $decrypted, $privKey);
        var_dump($encrypted);
        // dd($decrypted);

        Key::create(array(
            'patient_id' => $patientId,//query from tblUser
            'private_key' => $privKey,
            'public_key' => $pubKey
        ));
    }

    public function EncryptTreatmentHistory()
    {
        $patientId = '1';
        $key = Key::where('patient_id', '=', $patientId) -> first();
        $pubKey = $key -> public_key;
        
        $history = TreatmentHistory::where('patient_id', '=', $patientId) -> first();

        $nameHop = 'Thanh Hung';
        $server = NodeInfo::where('name_hopital','=',$nameHop) -> first();
        
        $name = $server -> name_hopital;
        $jsonServer = array(
            'ip' =>  $server -> ip_server,
            'name' => $server -> name_hopital,
        );
        $jsonHistory = array(
            'id' => $history -> id , 
            'treatment_id' => $history -> treatment_id,
            'patient_id' => $history -> patient_id, 
            'description' => $history -> description,
            'create_date' => $history -> create_date,
            'finish_date' => $history -> finish_date,
            'tooth_number' => $history -> tooth_number,
            'price' => $history -> price,
            'payment_id' => $history -> payment_id,
            'total_price' => $history -> total_price, 
        );  
        $mainJson = json_encode(array_merge($jsonHistory,$jsonServer));
        openssl_public_encrypt($mainJson, $encrypted, $pubKey);

        $priKey = $key -> private_key;
        var_dump($encrypted);
          
    }

    public function DecryptTreatmentHistory()
    {
        $patientId = '1';
        $key = Key::where('patient_id', '=', $patientId) -> first();
        $priKey = $key -> public_key;

        //

        openssl_private_decrypt($encrypted, $decrypted, $priKey);
        var_dump($decrypted); 
    }

    //
//    public function GenerateKey()
//    {
//
//        $rsa = new RSA();
//        $key = $rsa->createKey();
//        $privateKey = $key['privatekey'];
//        $publicKey = $key['publickey'];
//        $plaintext = '0123';
//        $password = '123456';
//        $method = 'aes-256-cbc';
//
//// Must be exact 32 chars (256 bit)
//        $password = substr(hash('sha256', $password, true), 0, 32);
//// IV must be exact 16 chars (128 bit)
//        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
//
//// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
//        $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
//        $enc = $this->encrypt($encrypted, $publicKey);
//        dd($encrypted);
//
//// My secret message 1234
//        $data = $this->decrypt($enc, $privateKey);
//        $decrypted = openssl_decrypt(base64_decode($data), $method, $password, OPENSSL_RAW_DATA, $iv);
//        dd($decrypted);
//    }

//    public function encrypt($data, $pubKey)
//    {
//        if (openssl_public_encrypt($data, $encrypted, $pubKey))
//            $data = base64_encode($encrypted);
//        else
//            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
//
//        return $data;
//    }
//
//    public function decrypt($data, $priKey)
//    {
//        if (openssl_private_decrypt(base64_decode($data), $decrypted, $priKey))
//            $data = $decrypted;
//        else
//            $data = '123';
//
//        return $data;
//    }
}
