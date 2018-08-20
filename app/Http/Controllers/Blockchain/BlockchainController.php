<?php

namespace App\Http\Controllers\Blockchain;

use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use App\Model\Blockchain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Key;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Array_;
use phpseclib\Crypt\RSA;
use App\Model\TreatmentHistory;
use App\Model\NodeInfo;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;
use App\Model\Payment;
use App\Model\PaymentDetail;
use File;
use App\Http\Controllers\Blockchain\QueueController;


class BlockchainController extends Controller
{
    use BlockchainBusinessFunction, QueueBusinessFunction;

    private $clientIp;

    public function __construct()
    {
        $this->clientIp = \request()->ip();
    }


    public function convertDataToJson()
    {
        $dataBlockchainObj = $this->getDataBlockChain();
        return $dataBlockchainObj->toJson();
    }

    public function getDataBlockchainJson()
    {
        $dataBlockchainJson = $this->convertDataToJson();
        return response($dataBlockchainJson);
    }

    public function callAPI_GetData($IP)
    {
        $client = new \GuzzleHttp\Client();
        // Create a request
        $request = $client->get('http://' . $IP . '/datajson');
        // Get the actual response without headers
        $response = $request->getBody()->getContents();
        $data = json_decode($response);

        return $data;
    }

    public function checkBlockChain($blockchain)
    {
        if ($blockchain[0]->previous_hash != 0)
            return false;
        for ($i = 0; $i < sizeof($blockchain) - 1; $i++) {
            if ($blockchain[$i]->hash != $blockchain[$i + 1]->previous_hash)
                return false;
        }
        return true;
    }

    public function compareBlockChain($listLedger)
    {
        $list = [];
        $count = [];

        foreach($listLedger as $ledger){
            $vt = -1;
            for($i = 0; $i < sizeOf($list); $i++){
                if($ledger == $list[$i]){
                    $vt = $i;
                    break;
                }
            }

            if($vt > -1){
                $count[$vt] += 1;
            }else{
                $list[] = $ledger;
                $count[] = 1;
            }
        }

        for($i = 0; $i < sizeOf($count); $i++){
            if($count[$i] == max($count)){
                return $list[$i];
            }
        }
    }


    public function saveNewLedger(Request $request)
    {
        if ($this->isExist($this->clientIp)) {
            $newestLedger = $this->callTheURL($this->clientIp . '/getThisLedger');
            if ($newestLedger != 'fail')
                return $this->saveNewAll(json_decode($newestLedger));
        }
        Log::info('BlockchainController_SaveNewLedger_ClientIpNotInNetwork: ' . $this->clientIp);
        return 'fail';
    }

    public function getThisLedger()
    {
        if ($this->isExist($this->clientIp)) {
            $result = Blockchain::all();
            return json_encode($result);
        }
        Log::info('BlockchainController_getThisLedger_ClientIpNotInNetwork: ' . $this->clientIp);
        return 'fail';
    }

    public function test(Request $request)
    {
        $dataEncrypt = $request->data_encrypt;
        $id = $request->id;
        $host = gethostname();
        $ip = gethostbyname($host);
        if ($dataEncrypt != null) {
            $url = $ip . '/runJobQueue?data_encrypt=' . $dataEncrypt;
            $result = $this->callTheURL($url);
            echo $result;
        } else if ($id != null) {
            $url = $ip . '/updateAll?id=' . $id;
            $result = $this->callTheURL($url);
            echo $result;
        }
//        $newestLedger = json_decode($this->callTheURL('150.95.110.217/datajson'));
//        array_push($newestLedger, json_decode($dataEncrypt));
//        return json_encode($newestLedger);
    }

    public function testPerformance()
    {
        $dataEncrypt = '{"data_encrypt":"TaiGay","previous_hash":"ThongNatDit","hash":"TuongAnTaiTro"}';
        $listNode = $this->getListNode();
        for ($i = 0; $i <= 10; $i++) {
            $j = rand() % count($listNode);
            $url = $listNode[$j]->ip . '/test?data_encrypt=' . $dataEncrypt;
            $client = new \GuzzleHttp\Client();
            $client->get($url);
        }
        return 'feeling';
    }

    public function checkLedger()
    {
        $nodeInfo = $this->getNodeInfo();
        $listLedger = [];

        for ($i = 0; $i < sizeOf($nodeInfo); $i++){
            $listLedger[] = $this->callAPI_GetData($nodeInfo[$i]->ip);
        }

        foreach($listLedger as $ledger){
            if(!($this->checkBlockChain($ledger)))
                return "ERROR";
        }
        
        return $this->compareBlockChain($listLedger);
    }

    public function setDataTypePayment($listStrings)
    {
        // $listStrings = array("5,2000000,50000000,01279011096,1,2017-08-08 20:00:00,1", "3, 60000000, 5, 2", "9, 4, 3, 2017-08-08 20:00:00, 222222, 3");
        // $arrayString = explode(',', $listStrings[0]);
        
        $this -> deleteDataPayment();

        foreach ($listStrings as $element) {
            $arrayString = explode(',', $element);
            dd($arrayString);
            if ($arrayString[sizeof($arrayString) - 1] == 1){}
                $this->setDataCreatePayment($arrayString);
            else if ($arrayString[sizeof($arrayString) - 1] == 2)
                $this->setDataUpdatePayment($arrayString);
            else
                $this->setDataPaymentDetail($arrayString);
        }
    }

    public function ReadPublickey()
    {
        $content = File::get(storage_path('public_key.txt'));
        return $content;
    }

    public function CheckPublicKeyNPrivateKey(Request $request)
    {
        $file = $request->file('privateKey')->openFile();
        dd($file->fread($file->getSize()));
        $privateKey = "";
        $encrypted = 'JATClEXRta22mqw6Z5blV5tQk/mcRYVfC/Roz6g1eyD4nrApq0MP4EWUiicftNzpt4k5F10kglsFiMOTp33ftidvkIX8lK7cTleUUN7BmAe/bj6zpCx6cDIxHjbHDhUR+Efc/lHRBQSqA2Wrkp2p66yolyClKHYFbz1KgcpDgmI=';
        // dd($privateKey);
        // $origin = "VALID KEY";
        // $privateKey = "-----BEGIN RSA PRIVATE KEY-----\r\nMIICXQIBAAKBgQCu/Fzjzta9P4X5eg58uJCYM2DqkBDixMsJXaywsrJNRwl4W4BB\r\n7Zck98q7NXmwa6kNHv8qIrLNgEpMhL5hBt+dVeSHHoutfhft9DTEaBbu7wrtoR1F\r\nmqxgpWhNO6CxKgVE480blf0mwBRI9CAvwqiuedAhQbSdRm8+v08YjhapVwIDAQAB\r\nAoGBAJYb7yONoDEgeTGWPy9GtOObz5voklO2NeaG8UlzQfmA4uLYu6HSy0HvP35x\r\nVT6+XHrhCEuBEJmxYAtcJGTfnJrUmtkaN8diMBa5oa8BMx9C+VUqMjw7GRh9fjJs\r\nZp1XngJ3ftiZmtxG798gAaSyoEL64fTcJ2FFJtq9jjURZ77BAkEA1ZYFN9aeTo+d\r\nKFJxHXgaK30GD9whfPnetN022qwgU7efSbfOv1jYpye/tP31Pbx1hf+ixQJ+sLi8\r\nTOHIMk2r2QJBANG8CiNkkEwA7PTv2wdKjVYs8zCvi1RewsCEv9AvOcNmY/OCPRTF\r\n1Cnhc9h0/ZLMLSv25AV7pxRM/tRg4UEBsK8CQDTKHYQNkZcNO+Spa7fC5YT2I7dr\r\nywMepwLA4jvt6xeF/OK1gW4dwX6e/mz3j9OwbsOtyUc0NKftIO1HqLl2JRECQBHb\r\nfNF+onqWKZbBRVjdlCMeOKaQi8BnQRW7N8m1+6kTcrctA55dKa9XLtHjRCPXlpED\r\nuG5vFM65r4jNpuAuEKkCQQCB5rjbTNkg0lYZo0ITwDq9zoyiKBHGc3ZvszilhlTF\r\nmtQMGrS/oWlVuxeuE8p7jGf+wzKWj10uXKHwNxFLd73v\r\n-----END RSA PRIVATE KEY-----";
        $file = File::get($request->privateKey);
        dd($file);
        $dec = $this->decrypt($encrypted, $privateKey);
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $method = 'aes-256-cbc';
        $decrypted = openssl_decrypt(base64_decode($dec), $method, '1', OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }

    public function EncryptCreatePayment(Request $request)
    {
        $id = $request->id;
        $payment = Payment::where('id', '=', $id)->first();
        $publicKey = $this->ReadPublickey();

        // $publicKey = "-----BEGIN PUBLIC KEY-----\r\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCu/Fzjzta9P4X5eg58uJCYM2Dq\r\nkBDixMsJXaywsrJNRwl4W4BB7Zck98q7NXmwa6kNHv8qIrLNgEpMhL5hBt+dVeSH\r\nHoutfhft9DTEaBbu7wrtoR1FmqxgpWhNO6CxKgVE480blf0mwBRI9CAvwqiuedAh\r\nQbSdRm8+v08YjhapVwIDAQAB\r\n-----END PUBLIC KEY-----";
        $dataPayment = $payment->id . "," . $payment->paid . "," . $payment->total_price . "," . $payment->phone . "," . $payment->is_done . "," . $payment->created_at . ',1';
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $method = 'aes-256-cbc';
        $encrypted = base64_encode(openssl_encrypt($dataPayment, $method, '1', OPENSSL_RAW_DATA, $iv));
        // dd($publicKey);
        // $queue = new QueueController();
        // $queue -> runJobQueue()
        // $url = "127.0.0.1/";
        $host = gethostname();
        $ip = gethostbyname($host);
        $url = $ip . "/runJobQueue?data_encrypt=" . $this->encrypt($encrypted, $publicKey);
        $this->callTheURL($url); 
        // return $this->encrypt($encrypted, $publicKey);
    }

    public function TestUpdatePayment()
    {
        $idPayment = '1';
        $idTreatment = '1';
        $price = "20000";
        return $this->EncryptUpdatePayment($idPayment, $idTreatment, $price);
    } // just for test

    public function EncryptUpdatePayment($idPayment, $idTreatment, $price)
    {
        $publicKey = $this->ReadPublickey();
        $dataPayment = $idPayment . "," . $price . "," . $idTreatment . ",2";
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $method = 'aes-256-cbc';
        $encrypted = base64_encode(openssl_encrypt($dataPayment, $method, '1', OPENSSL_RAW_DATA, $iv));
        // dd($publicKey);
        return $this->encrypt($encrypted, $publicKey);
    }

    public function EncryptCreatePaymentDetail($idPaymentDetail)
    {
        $payment = PaymentDetail::where('id', '=', $idPaymentDetail)->first();
        $publicKey = $this->ReadPublickey();
        // $publicKey = "-----BEGIN PUBLIC KEY-----\r\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCu/Fzjzta9P4X5eg58uJCYM2Dq\r\nkBDixMsJXaywsrJNRwl4W4BB7Zck98q7NXmwa6kNHv8qIrLNgEpMhL5hBt+dVeSH\r\nHoutfhft9DTEaBbu7wrtoR1FmqxgpWhNO6CxKgVE480blf0mwBRI9CAvwqiuedAh\r\nQbSdRm8+v08YjhapVwIDAQAB\r\n-----END PUBLIC KEY-----";

        $dataPaymentDetail = $payment->id . "," . $payment->payment_id . "," . $payment->staff_id . "," . $payment->date_create . "," . $payment->received_money . ',3';
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $method = 'aes-256-cbc';
        $encrypted = base64_encode(openssl_encrypt($dataPaymentDetail, $method, '1', OPENSSL_RAW_DATA, $iv));
        // dd($publicKey);
        return $this->encrypt($encrypted, $publicKey);
    }

    public function DecryptDataBlock($id)
    {
        $encrypted = Blockchain::where('id', '=', $id)->first()->data_encrypt;
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\r\nMIICXQIBAAKBgQCu/Fzjzta9P4X5eg58uJCYM2DqkBDixMsJXaywsrJNRwl4W4BB\r\n7Zck98q7NXmwa6kNHv8qIrLNgEpMhL5hBt+dVeSHHoutfhft9DTEaBbu7wrtoR1F\r\nmqxgpWhNO6CxKgVE480blf0mwBRI9CAvwqiuedAhQbSdRm8+v08YjhapVwIDAQAB\r\nAoGBAJYb7yONoDEgeTGWPy9GtOObz5voklO2NeaG8UlzQfmA4uLYu6HSy0HvP35x\r\nVT6+XHrhCEuBEJmxYAtcJGTfnJrUmtkaN8diMBa5oa8BMx9C+VUqMjw7GRh9fjJs\r\nZp1XngJ3ftiZmtxG798gAaSyoEL64fTcJ2FFJtq9jjURZ77BAkEA1ZYFN9aeTo+d\r\nKFJxHXgaK30GD9whfPnetN022qwgU7efSbfOv1jYpye/tP31Pbx1hf+ixQJ+sLi8\r\nTOHIMk2r2QJBANG8CiNkkEwA7PTv2wdKjVYs8zCvi1RewsCEv9AvOcNmY/OCPRTF\r\n1Cnhc9h0/ZLMLSv25AV7pxRM/tRg4UEBsK8CQDTKHYQNkZcNO+Spa7fC5YT2I7dr\r\nywMepwLA4jvt6xeF/OK1gW4dwX6e/mz3j9OwbsOtyUc0NKftIO1HqLl2JRECQBHb\r\nfNF+onqWKZbBRVjdlCMeOKaQi8BnQRW7N8m1+6kTcrctA55dKa9XLtHjRCPXlpED\r\nuG5vFM65r4jNpuAuEKkCQQCB5rjbTNkg0lYZo0ITwDq9zoyiKBHGc3ZvszilhlTF\r\nmtQMGrS/oWlVuxeuE8p7jGf+wzKWj10uXKHwNxFLd73v\r\n-----END RSA PRIVATE KEY-----";
        // $decrypted = decrypt($encrypted, $privateKey);
        $dec = $this->decrypt($encrypted, $privateKey);
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $method = 'aes-256-cbc';
        $decrypted = openssl_decrypt(base64_decode($dec), $method, '1', OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

    public function TestHashBlock()
    {
        $encrypted = '0';
        $preHash = '0';
        return $this->HashOfBlock($encrypted, $preHash);
    } // just for test

    public function HashOfBlock($encrypted, $preHash)
    {
        $hashOrigin = $encrypted . time() . $preHash;
        $hash = hash("sha256", $hashOrigin);
        return $hash;
    }

    public function encrypt($data, $pubKey)
    {
        if (openssl_public_encrypt($data, $encrypted, $pubKey)) {
            $data = base64_encode($encrypted);
        } else {
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
        }
        return $data;
    }

    public function decrypt($data, $priKey)
    {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $priKey)) {
            $data = $decrypted;
        }
        return $data;
    }

    public function GenerateKey()
    {
        // $payment = Payment::where('id', '=', $id)->first();
        $rsa = new RSA();
        $key = $rsa->createKey();
        $privateKey = $key['privatekey'];
        $publicKey = $key['publickey'];
        // dd($publicKey);
        // $publicKey =
        // "-----BEGIN PUBLIC KEY-----\r\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDHmgT9iPALr794vrm6AbSTL0Uy\r\npY36+ZS2Oxetzut6PjngwqWLabPmxXeC5LUHRFdl8+1k7BEIAOypt2LDU3EqtbDj\r\n5v3joZNVthGCgv8+GkLGhr0rPXNqR0PuHFcONuoM2pg0Tj9l6qhcHA4gppOjCYhU\r\nNtNkItV1mgHCK0mTewIDAQAB\r\n-----END PUBLIC KEY-----";
        // $publicKey = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDB7dB6ZVYqJ0W31gsRuhKnBAsOK5o3qSDXXeM4MQ/HAmm/aUjA8FFyZT3R/1JmNDA7vo7g1PscftLxhFWib/v/w79gH6bpC+R8wMu3OYvHaHSSz+v+naOMyh+0IAIjEYxOUnTEWpfZHegaMAAz3YGR60thr2a2yc/zNgBSFFbokQIDAQAB-----END PUBLIC KEY-----';
        // $privateKey = '-----BEGIN RSA PRIVATE KEY----- MIICXgIBAAKBgQC+fdJFgNTErTb3WntzFac5GdfHFGOy6pt1tLI+wK13VIDak0o/ w6vRr2bkLO4R+WJKbKW/itZgrhy0n3q24AghRqldOmkSBBhJH/3pWa/HPCJP2NHR dzETYNjq53F8SgPw1/XehuZWkgsxCjWJcpYBgwT/Zsl3OGBrX8uQORPMkQIDAQAB AoGBAKz/2fpzQUiJQzUrgJgJH0CVfsj3dIAl3x/sBkFFfYS1Qvy+7ZyxWRbq5Ffv khrS0PhkabdmIMHW/ozvlWQGXHpCelrUj4S+TC89JbAOhVWkwRfEDvj7NzRpTz4N hQUmA5OAU1x1x7hqYL7Cs3yNVxfGOhTuolk+uOtJZQk+Jf2RAkEA5+VU7HkU0P8D rWBvoDrq0GLXbO7Y5ap1+QG4ZqezVsy1qbGa8YrQJVPcGHK6svvsLLHcaax3/0xs N6F64qY6xQJBANJKvAUIEMmupL4VWPuzefaDP29UIk07Pj/G49uM/EEGUhN/NTVY thgHuDwE62HGHRumLIem6wddX85/OeNR110CQQC3GQpe1JOtGU2r/XLlzt9Mvl5e MpCrdlZD0CnrVAp0RJpDbGpswS/r6TTlUOE9JVCrUZw5C+aLe6oOmr/OaXYJAkEA mUqrJkvL2Qi6xGlRVSFujXj9G81Lt9qwtNLptFhgZZIS8G1xPvLswjWWYgIAB2Tg QRBwM25EsziopyFs9DzrbQJAKuwMN4R4imuuA/5z85/bEu1r05J9w1T0wo93zp2w 0gQzaDxVvOlYlm7sDMYf7cvdL2y8WkWdzWgU6UQFtktiOg== -----END RSA PRIVATE KEY-----';
        dd($publicKey . $privateKey);

        // $privateKey ='MIICWwIBAAKBgQDDxLo9OrtMtxndfT9Wr/xAU5fsYuTGLaJdoj6po0aZrl/3VQNs T4EhzZ0aS/7OFTfxlKUr2qnL4OOwL+4kiRDGrHuX3N4u5QJ/sDFLwvWvOC+86fZN aWFRONNWl0bHVYsME+8Eb1iC8rAisi8it4rybYHykso/fL0z4N7fMGnXWwIDAQAB AoGAJs8ZHIpIFy01M3Ng2w6IMzhfJb11HNRvG6DOS1LS7CRlYeK4iwA32TupqUzn dnM+Y+XT2J3Ai2pJuOPHkfaaHG/PHE2AGvbWCQUCa8JEScqUDpdGHS2EaYPQQ6Ph 8V5ylDa2jJZkt0SJY/2GZqBG1j3NQjGC1CkrvUk8Wo9ylAECQQDjxDd+wRwnd3XN HL1JfyjWxh4IWWyBsIM2oEbKKahKOT8V0wZnwOsIaOrA+7FFzYqE+N8ki9NvmVB5 GDTuKJ8zAkEA3AkbtJGOgU6Caw1KSJhWKpkLveT85IGw13H4Ev5vvvI4odaRUkkj FSRe5kbofDGcyE8Q7saB4kPrMGnmjuwHOQJAOiZydK4g3gKl1MQtn4ITjyHtsPwD s+i41018RUj1al3LOWszC3I5j2AZ70NTMxsS7ngLoG0Cgk+GOCRx/wvn+QJAX0Ke OQWPUZIAyoH9eAJjw5twxuydQ/yV6CBSSz7WeC97ry0qyxoY0y1k3IM0YZhFDT+V 0Bom3yOSbepbQ+MRmQJAbOvHPrWw4uCVbpaiIDHhKWYC0mt++W/ujNrPBcyFHkMP qoADJnc3d8mm0XUjm3osJ+kgvwuf6LqZdWWQrmT7rQ==';
        // $publicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDxLo9OrtMtxndfT9Wr/xAU5fs YuTGLaJdoj6po0aZrl/3VQNsT4EhzZ0aS/7OFTfxlKUr2qnL4OOwL+4kiRDGrHuX 3N4u5QJ/sDFLwvWvOC+86fZNaWFRONNWl0bHVYsME+8Eb1iC8rAisi8it4rybYHy kso/fL0z4N7fMGnXWwIDAQAB';
        // $paymentArray = array(
        //     'id' => $payment->id,
        //     'paid' => $payment->paid,
        //     'total_price' => $payment->total_price,
        //     'phone' => $payment->phone,
        //     'is_done' => $payment->is_done,
        //     'created_at' => $payment->created_at,
        //     'type' => 1 // 1 is create payment
        // );
        //         $jsonPayment = json_encode($paymentArray);
        // $dataPayment = $payment->id . "," . $payment->paid . "," . $payment->total_price . "," . $payment->phone . "," . $payment->is_done . "," . ',2';
        $plaintext = "1222,2000000,50000000,01279011096,1,2017-08-08 20:00:00,1";
        // // var_dump($dataPayment);
        $method = 'aes-256-cbc';
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $encrypted = base64_encode(openssl_encrypt($plaintext, $method, '1', OPENSSL_RAW_DATA, $iv));
        $enc = $this->encrypt($encrypted, $publicKey);

        $dec = $this->decrypt($enc, $privateKey);
        dd($encrypted);
        $decrypted = openssl_decrypt(base64_decode($dec), $method, '1', OPENSSL_RAW_DATA, $iv);
        dd($decrypted);
        // return $encrypted;
    }

}
