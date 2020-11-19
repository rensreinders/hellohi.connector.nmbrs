# NMBRS SDK PHP

## Init the client
> Note: the user should have access to all the resource in nmbrs. You can manage this trough user templates.
```php
use Mijnkantoor\NMBRS\NmbrsClient;
include(__DIR__ . "/vendor/autoload.php");
$client = new \Mijnkantoor\NMBRS\NmbrsClient("your-email-here", "your-token-here", "your-domai-here");
```

# Create a company
> Note: every company belongs to a debtor, so we creat that object first

**First create a debtor**
```php
$highestDebNumber = $highestDebNumber = $client->getHighestDebtorNumber();
$debtor = $client->createDebtor('Some debtor', $highestDebNumber + 1));
```

**Create a company for the debtor**
```php
$highestDebNumber = $client->getHighestDebtorNumber();
$client->createDebtor('Some client', $highestDebNumber + 1);

$highestCompanyNumber = $client->getHighestCompanyNumber();
$company = $client->createCompanyForDeptor($debtor->Id, [
    'Number' => $highestCompanyNumber,
    'CompanyName' => 'MKA Test 24',
    'PeriodType' => NmbrsClient::DeclarationPeriodMonth,
    'DefaultCompanyId' => -1,
    'LabourAgreementSettingsGroupGuid' => '00000000-0000-0000-0000-000000000000',
    'PayInAdvance' => false
]);
```

**Create an address for company**
```php
$address = $client->createAddressForCompany($company->Id, [
    'Default' => true,
    'Street' => 'Some Street',
    'HouseNumber' => '123',
    'HouseNumberAddition' => 'A',
    'PostalCode' => '1234 AB',
    'City' => 'Some City',
    'StateProvince' => 'Some Province',
    'CountryISOCode' => 'nl',
]);
```

**Create a bank account**
```php
$bankAccount = $client->createBankAccountForCompany($company->id, [
    'Description' => 'Test rekening',
    'IBAN' => 'GB33BUKB20201555555555',
    'BIC' => 'ABNANL2A',
    'City' => 'TestDorp',
    'Name' => 'Henk',
    'Type' => 'Standaard',
]);
```

## Update a company
**First update debtor**
```php
$client->updateDebtor($debtor->id, ['Name' => 'Other Debtor']);
```
**Update an address for company**
```php
// oops, doesn't exist at nmbrs API
````

**Update an address for company**
> Note: the update is in fact a delete and insert, so there is a new addressId on every update
```php
$currentAddress = $client->getCurrentAddressByCompanyId($company->id));

$client->updateAddressForCompany($company->id, $currentAddress->id, [
    'Default' => true,
    'Street' => 'Other Street',
    'HouseNumber' => '123',
    'HouseNumberAddition' => 'A',
    'PostalCode' => '1234 AB',
    'City' => 'Other City',
    'StateProvince' => 'Other Province',
    'CountryISOCode' => 'nl',
]);
```

**Update the default bankaccount for a company** 
```php
$currentBankAccount = $client->getDefaultBankAccountForCompany($company->id);

$client->updateBankAccountForCompany($company->id, $currentBankAccount->id, [
    'Description' => 'Test rekeninger',
    'IBAN' => 'NL70RABO4636681924',
    'Type' => 'Standaard',
]);
```
