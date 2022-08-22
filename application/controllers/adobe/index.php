<?php
require_once('vendor/autoload.php');
use KevinEm\AdobeSign\AdobeSign;
use GuzzleHttp\Psr7;
$provider = new KevinEm\OAuth2\Client\AdobeSign([
    'clientId'          => 'CBJCHBCAABAA14B-5i5PO0Cka8ADRx_UkKNtwN7XzC7-',
    'clientSecret'      => 'uB8vk1MOrl4vmYSIhEPQ1g4E0gOMRxdN',
    'redirectUri'       => 'https://localhost/adobe/index.php',
	'dataCenter'        => 'secure.na1', 
    'scope'             => [
          'user_login:account',
		  'agreement_write:account',
		  'widget_write:account',
		  'library_write:account',
		  'agreement_send:account'		  
    ]
]);

$adobeSign = new AdobeSign($provider);

if (!isset($_GET['code'])) {
    $authorizationUrl = $adobeSign->getAuthorizationUrl();
	//echo $authorizationUrl;exit;
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authorizationUrl);
} elseif (empty($_GET['state'])){ // || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    //$accessToken = '3AAABLblqZhAMawbuY28SGdusKous8yWnsqjSdzsYo00eVXQh17IFzHmKe-i2OpXU5o8Hoyq_86n-kfwdH8p8y_rnbgsWyNPR';
	$accessToken=$adobeSign->getAccessToken($_GET['code']);
	//echo $accessToken->getToken(); exit;
    $adobeSign->setAccessToken($accessToken->getToken());
	//'3AAABLblqZhDlKizVs3uBWRo00KMuVD6zTDYYCQmfzovAP-AhV2rt_3NKo6aBYcaEyozDATGdCw6twaZBcIflMA9RXsQCEpd_');
    $archivos=array('agreement-1.pdf','agreement-2.pdf');
	$todosDoc=array();
	foreach ($archivos as $doc) {
	  $file_path = $doc;
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
	}
	$agreement = $adobeSign->createAgreement([
        'documentCreationInfo' => [
            'fileInfos'         => [
			 $todosDoc
                //'libraryDocumentId' => '3AAABLblqZhAd2bFY2T8DeQz6lnF6jfzG5dPbq4vC7cMxikum2YudCnMWvU_xMeoOvI5jeWkR4qcgvSZH4vTJJRSU2pvCea14MA7znxkSe_jrBeEuKwIoiBNYcDd43UTcDH23gcNjiBn_Ygma1p0BZZHtAOMriYnNCf7zQuN49Rw2FSMOwOCH454TZfAEFD4KLNP9BtjIk8yhpm133c2SknLT5dYlsbaevEklEdp9Eyic6xLINhEkqDfPTCtG0d5GWdndDWCRV0JrRmPLlzcMvkwzZqYGeze_Oay3H9aNFx9vVIFVBnaxn-E9Yc-PDId-YQzASxlN5CM*'
            ],
            'name'              => 'My Document',
            'signatureType'     => 'ESIGN',
            'recipientSetInfos' => [
                'recipientSetMemberInfos' => [
                    'email' => 'kunikvinay@gmail.com'
                ],
                'recipientSetRole'        => [
                    'SIGNER'
                ]
            ],
            'mergeFieldInfo'    => [
                [
                    'fieldName'    => 'Name',
                    'defaultValue' => 'Entigrity Staffing'
                ]
            ],
            'signatureFlow'     => 'SENDER_SIGNATURE_NOT_REQUIRED'
        ]
    ]);
	var_dump($agreement);
}
?>