
```php
$builder = DefaultEsiaGatewayClientBuilder::create(
    new Psr18Client(new CurlHttpClient(), new HttpFactory(), new HttpFactory()),
    'YOUR_CLIENT_ID',
    'YOUT_CLIENT_SECRET',
);

$client = $builder->createEsiaGatewayClient('https://demo.gate.esia.pro');
```
