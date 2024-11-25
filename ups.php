<?php

// Initialize variables
$accessLicenseNumber = 'YOUR_ACCESS_LICENSE_NUMBER';
$userId = 'YOUR_USER_ID';
$password = 'YOUR_PASSWORD';

$shipperName = 'Shipper Name';
$shipperNumber = 'Shipper Number';
$shipperAddressLine = 'Shipper Address Line';
$shipperCity = 'Shipper City';
$shipperState = 'Shipper State';
$shipperPostalCode = 'Shipper Postal Code';
$shipperCountryCode = 'Shipper Country Code';

$recipientName = 'Recipient Name';
$recipientAddressLine = 'Recipient Address Line';
$recipientCity = 'Recipient City';
$recipientState = 'Recipient State';
$recipientPostalCode = 'Recipient Postal Code';
$recipientCountryCode = 'Recipient Country Code';

$senderName = 'Sender Name';
$senderAddressLine = 'Sender Address Line';
$senderCity = 'Sender City';
$senderState = 'Sender State';
$senderPostalCode = 'Sender Postal Code';
$senderCountryCode = 'Sender Country Code';

$serviceCode = '03';  // Service code for UPS Ground
$serviceDescription = 'Ground';

$packageCode = '02';  // Code for package
$packageDescription = 'Package';
$packageLength = '10';
$packageWidth = '5';
$packageHeight = '5';
$packageWeight = '1';
$unitOfMeasurement = 'IN';
$weightUnit = 'LBS';

function getUpsRates(
    $accessLicenseNumber, $userId, $password,
    $shipperName, $shipperNumber, $shipperAddressLine, $shipperCity, $shipperState, $shipperPostalCode, $shipperCountryCode,
    $recipientName, $recipientAddressLine, $recipientCity, $recipientState, $recipientPostalCode, $recipientCountryCode,
    $senderName, $senderAddressLine, $senderCity, $senderState, $senderPostalCode, $senderCountryCode,
    $serviceCode, $serviceDescription,
    $packageCode, $packageDescription, $packageLength, $packageWidth, $packageHeight, $packageWeight, $unitOfMeasurement, $weightUnit
) {
    $url = 'https://onlinetools.ups.com/rest/Rate';

    $payload = json_encode([
        'UPSSecurity' => [
            'UsernameToken' => [
                'Username' => $userId,
                'Password' => $password,
            ],
            'ServiceAccessToken' => [
                'AccessLicenseNumber' => $accessLicenseNumber,
            ],
        ],
        'RateRequest' => [
            'Request' => [
                'RequestOption' => 'Rate',
                'TransactionReference' => [
                    'CustomerContext' => 'Your Customer Context',
                ],
            ],
            'Shipment' => [
                'Shipper' => [
                    'Name' => $shipperName,
                    'ShipperNumber' => $shipperNumber,
                    'Address' => [
                        'AddressLine' => $shipperAddressLine,
                        'City' => $shipperCity,
                        'StateProvinceCode' => $shipperState,
                        'PostalCode' => $shipperPostalCode,
                        'CountryCode' => $shipperCountryCode,
                    ],
                ],
                'ShipTo' => [
                    'Name' => $recipientName,
                    'Address' => [
                        'AddressLine' => $recipientAddressLine,
                        'City' => $recipientCity,
                        'StateProvinceCode' => $recipientState,
                        'PostalCode' => $recipientPostalCode,
                        'CountryCode' => $recipientCountryCode,
                    ],
                ],
                'ShipFrom' => [
                    'Name' => $senderName,
                    'Address' => [
                        'AddressLine' => $senderAddressLine,
                        'City' => $senderCity,
                        'StateProvinceCode' => $senderState,
                        'PostalCode' => $senderPostalCode,
                        'CountryCode' => $senderCountryCode,
                    ],
                ],
                'Service' => [
                    'Code' => $serviceCode,
                    'Description' => $serviceDescription,
                ],
                'Package' => [
                    'PackagingType' => [
                        'Code' => $packageCode,
                        'Description' => $packageDescription,
                    ],
                    'Dimensions' => [
                        'UnitOfMeasurement' => [
                            'Code' => $unitOfMeasurement,
                        ],
                        'Length' => $packageLength,
                        'Width' => $packageWidth,
                        'Height' => $packageHeight,
                    ],
                    'PackageWeight' => [
                        'UnitOfMeasurement' => [
                            'Code' => $weightUnit,
                        ],
                        'Weight' => $packageWeight,
                    ],
                ],
            ],
        ],
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
