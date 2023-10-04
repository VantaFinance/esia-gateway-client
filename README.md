
```php
$builder = DefaultEsiaGatewayClientBuilder::create(
    new Psr18Client(new CurlHttpClient(), new HttpFactory(), new HttpFactory()),
    'YOUR_CLIENT_ID',
    'YOUT_CLIENT_SECRET',
);
$client = $builder->createEsiaGatewayClient('https://demo.gate.esia.pro', 'https://pos-credit.ru');

$authorizationUrl = $client->createAuthorizationUrlBuilder()
    ->withPermission(ScopePermission::DRIVERS_LICENSE_DOC)
    ->withoutPermission(ScopePermission::MOBILE)
    ->build()
;
```

Get code after redirect, then use it

```php
$accessToken = $client->getAccessTokenByAuthorizationCode($code);

$userInfo = $client->getUserInfo($accessToken);
```
