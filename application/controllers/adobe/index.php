<?php
use KevinEm\AdobeSign\AdobeSign;
use GuzzleHttp\Psr7;
function getPdfAuthProvider($redirectUri='https://hashevo.com/elightsolar/admin/contracts/send_contract_for_adobe_sign/'){
    require_once('vendor/autoload.php');
    
    $provider = new KevinEm\OAuth2\Client\AdobeSign([
        'clientId'          => 'CBJCHBCAABAAMV3qh5Ule4MQzSIZyPfAHFCkC-WXeWAB',
        'clientSecret'      => 'Nwe3L6ySL-UsF2wnBh079NkZhlVQaB9o',
        'redirectUri'       => $redirectUri,
        'dataCenter'        => 'secure.na1', 
        'scope'             => [
            'user_login:account',
            'agreement_write:account',
            'widget_write:account',
            'library_write:account',
            'agreement_send:account'		  
        ]
    ]);
    return $provider;
}

function signJoineeDocuments($code='',$email='',$docs=[],$id=''){
    if(!empty($docs)){
        require_once('vendor/autoload.php');
        $adobeSign = new AdobeSign(getPdfAuthProvider('https://hashevo.com/elightsolar/admin/contracts/send_contract_for_adobe_sign'));
        if($code==''){
            redirect($adobeSign->getAuthorizationUrl());
            exit;
        }
        //echo $email;die();
        print_r($docs);
        $accessToken=$adobeSign->getAccessToken($code);
        $access_token=$accessToken->getToken();
        $adobeSign->setAccessToken($access_token);
        foreach($docs as $key=>$val){
            $todosDoc=array();
            $file_path = $val;
            $file_stream = Psr7\FnStream::decorate(Psr7\stream_for(file_get_contents($file_path)), [
                'getMetadata' => function() use ($file_path) {
                    return $file_path;
                }
            ]);
            $multipart_stream   = new Psr7\MultipartStream([
                [
                    'name'     => 'File',
                    'contents' => $file_stream
                ]
            ]);
            $transient_document = $adobeSign->uploadTransientDocument($multipart_stream);
            array_push($todosDoc, $transient_document);

            $agreement = $adobeSign->createAgreement([
                'documentCreationInfo' => [
                    'fileInfos'         => [
                     $todosDoc
                        //'libraryDocumentId' => '3AAABLblqZhAd2bFY2T8DeQz6lnF6jfzG5dPbq4vC7cMxikum2YudCnMWvU_xMeoOvI5jeWkR4qcgvSZH4vTJJRSU2pvCea14MA7znxkSe_jrBeEuKwIoiBNYcDd43UTcDH23gcNjiBn_Ygma1p0BZZHtAOMriYnNCf7zQuN49Rw2FSMOwOCH454TZfAEFD4KLNP9BtjIk8yhpm133c2SknLT5dYlsbaevEklEdp9Eyic6xLINhEkqDfPTCtG0d5GWdndDWCRV0JrRmPLlzcMvkwzZqYGeze_Oay3H9aNFx9vVIFVBnaxn-E9Yc-PDId-YQzASxlN5CM*'
                    ],
                    'name'              => $key,
                    'signatureType'     => 'ESIGN',
                    'recipientSetInfos' => [
                        'recipientSetMemberInfos' => [
                            'email' => $email
                        ],
                        'recipientSetRole'        => [
                            'SIGNER'
                        ]
                    ],
                    'mergeFieldInfo'    => [
                        [
                            'fieldName'    => 'Name',
                            'defaultValue' => 'Elite Solar'
                        ]
                    ],
                    'signatureFlow'     => 'SENDER_SIGNATURE_NOT_REQUIRED'
                ]
            ]);
            $docs[$key]=$agreement;
        }
        return $docs;
    }
    else{
        return false;
    }
}
?>