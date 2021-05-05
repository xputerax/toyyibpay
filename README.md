# PHP ToyyibPay Library (unofficial)

Unofficial PHP library for toyyibPay payment gateway. This package is heavily inspired by [jomweb/billplz](https://github.com/jomweb/billplz). Please consult the [official API reference](https://toyyibpay.com/apireference/) for a detailed explanation.

* [Installation](#installation)
* [Getting started](#getting-started)
  * [Creating a client](#creating-a-client)
  * [Using sandbox mode](#using-sandbox-mode)
* [Usage](#usage)
  * [Bank](#bank)
    * [Get bank list](#get-bank-list)
    * [Get bank FPX codes](#get-bank-fpx-codes)
  * [Package](#package)
    * [Get package list](#get-package-list)
  * [User](#user)
    * [Create user](#create-user)
    * [Get user status](#get-user-status)
    * [Get all user](#get-all-user)
  * [Category](#category)
      * [Create category](#create-category)
      * [Get category](#get-category)
  * [Bill](#bill)
    * [Create a bill](#create-a-bill)
    * [Create a multi-payment bill](#create-amulti-payment-bill)
    * [Run bill](#run-bill)
    * [Get all bills](#get-all-bills)
    * [Get bill transactions](#get-bill-transactions)
  * [Settlement](#settlement)
    * [Get all settlement](#get-all-settlement)
    * [Get settlement summary](#get-settlement-summary)
* [Contribution](#contribution)
* [Developer's Note](#developers-note)
* [License](#license)

## Installation

```
$ composer require aimandaniel/toyyibpay
```

## Getting started

### Creating a client

```php
use AimanDaniel\ToyyibPay\Client;

$client = Client::make('your-secret-key', 'your-category-code');
```

You can also pass a HTTP client directly:

```php
use AimanDaniel\ToyyibPay\Client;

$http = Laravie\Codex\Discovery::client();

$client = new Client($http, 'your-secret-key', 'your-category-code');
```

### Using sandbox mode

You can enable sandbox environment by adding the following line:

```php
$client->useSandbox();
```

## Usage

### Bank

You can create a `Bank` instance as follows:

```php
$bank = $client->bank();
// or
$bank = $client->uses('Bank');
```

> You can pass the API version manually by doing `$client->bank('v1')` or `$client->uses('Bank', 'v1')` but currently the API only has one version and it is set as the default one

#### Get bank list

```php
$response = $bank->all();

var_dump($response->toArray());
```

#### Get bank FPX codes

```php
$response = $bank->fpx();

var_dump($response->toArray());
```

### Package

Create a `Package` instance:

```php
$package = $client->package();
// or
$package = $client->uses('Package');
```

#### Get package list

```php
$response = $package->all();

var_dump($response->toArray());
```

### User

Create a `User` instance:

```php
$user = $client->user();
// or
$user = $client->uses('User');
```

#### Create User

```php
$response = $user->create(
  string $fullname,
  string $username,
  string $email,
  string $password,
  string $phone,
  int $bank, // same id as in $bank->all()
  string $accountNo, // bank acc number
  string $accountHolderName, // bank acc holder
  ?string $registrationNo,
  ?int $package,
  ?int $userStatus
);

var_dump($response->toArray());
```

#### Get user status

```php
$response = $user->status($username);

var_dump($response->toArray());
```

#### Get all user

```php
$partnerType = 'OEM'; // or 'ENTERPRISE', defaults to OEM if null

$response = $user->all($partnerType);

var_dump($response->toArray());
```

### Category

Create a `Category` instance as follows:

```php
$category = $client->category();
// or
$category = $client->uses('Category');
```

#### Create category

```php
$response = $category->create(
  string $categoryName,
  string $categoryDescription
);

var_dump($response->toArray());
```

#### Get category

```php
$response = $category->get('category code');

var_dump($response->toArray());
```

### Bill

Create a `Bill` instance:

```php
$bill = $client->bill();
// or
$bill = $client->uses('Bill');
```

#### Create a bill

```php
$response = $bill->create(
  string $billName,
  string $billDescription,
  int $billPriceSetting,
  int $billPayerInfo,
  string $billAmount,
  string $billReturnUrl,
  string $billCallbackUrl,
  string $billExternalReferenceNo,
  ?string $billTo,
  string $billEmail,
  string $billPhone,
  array $optionals = []
);

var_dump($response->toArray());
```

```$optionals``` expects an associative array of any of these values:

| Key 	| Expected Value 	| Default Value 	|
|-	|-	|-	|
| billSplitPayment 	| Bill::PAYMENT_SPLIT (1) <br> (empty) <br> 	| (empty) 	|
| billSplitPaymentArgs 	| JSON String 	| (empty) 	|
| billPaymentChannel 	| Bill::PAYMENT_CHANNEL_FPX (0) <br> Bill::PAYMENT_CHANNEL_CC (1) <br> Bill::PAYMENT_CHANNEL_BOTH (2) <br> 	| Bill::PAYMENT_CHANNEL_BOTH (2) 	|
| billDisplayMerchant 	| Bill::MERCHANT_HIDE (0) <br> Bill::MERCHANT_DISPLAY (1) <br> 	| Bill::MERCHANT_DISPLAY (1) 	|
| billContentEmail 	| (string) 	| (empty) 	|
| billChargeToCustomer 	| Bill::CHARGE_OWNER_BOTH (null) <br> Bill::CHARGE_FPX_CUSTOMER_CC_OWNER (0) <br> Bill::CHARGE_FPX_OWNER_CC_CUSTOMER (1) <br> Bill::CHARGE_CUSTOMER_BOTH (2) <br> 	| Bill::CHARGE_OWNER_BOTH (null) 	|


#### Create a multi-payment bill

```php
$response = $bill->createMultiPayment(
  string $billName,
  string $billDescription,
  string $billPriceSetting,
  string $billPayerInfo,
  string $billAmount,
  string $billReturnUrl,
  string $billCallbackUrl,
  string $billExternalReferenceNo,
  string $billTo,
  string $billEmail,
  string $billPhone,
  string $billSplitPayment,
  string $billSplitPaymentArgs,
  string $billMultiPayment,
  string $billPaymentChannel,
  string $billDisplayMerchant,
  string $billContentEmail
);

var_dump($response->toArray());
```

#### Run bill

```php
$response = $bill->run(
  string $billCode,
  string $billpaymentAmount,
  string $billpaymentPayerName,
  string $billpaymentPayerPhone,
  string $billpaymentPayerEmail,
  string $billBankID
);

var_dump($response->toArray());
```

#### Get all bills

```php
$partnerType = 'OEM'; // or 'ENTERPRISE'
$yearMonth = '2020-01';

$response = $bill->all(
  string $partnerType,
  ?string $yearMonth = null
);

var_dump($response->toArray());
```

#### Get bill transactions

```php
$response = $bill->transactions(
  string $billCode,
  ?int $billpaymentStatus = 1
);

var_dump($response->toArray());
```

### Settlement

Create a `Settlement` instance:

```php
$settlement = $client->settlement();
// or
$settlement = $client->uses('settlement');
```

#### Get all settlement

```php
$response = $settlement->all(
  string $partnerType,
  bool $groupByUsername
);

var_dump($response->toArray());
```

#### Get settlement summary

```php
$response = $settlement->summary(
  string $partnerType,
  bool $groupByUsername
);

var_dump($response->toArray());
```


## Contribution

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Developer's Note

The API version declared in this package is v1 even though the official [API reference](https://toyyibpay.com/apireference/) does not explicitly declare it as such

## License

[MIT](https://choosealicense.com/licenses/mit/)