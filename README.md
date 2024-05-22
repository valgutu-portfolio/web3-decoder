# Run Docker containers
make up

Localhost URL: http://localhost:80

# API 
POST `{{url}}/api/logs/decode`

Request Body:
```
{
    "__comment": "https://etherscan.io/tx/0x1d52d80fedb68fee449ecedbc7d0e1a04118da497ec6229f59487ef03f689a02#eventlog",
    "logs": {
        "topics": [
            "0x6f225532a9c33b023b8e48247ad8df9d98f132ae17c769b97ff22d2b278fa73a",
            "0x00000000000000000000000097d2091959d48e466fc485d0f6ad30ac0078b01d",
            "0x0000000000000000000000000000000000000000000000000000000000121074",
            "0x0000000000000000000000000000000000000000000000000000000000000000"
        ],
      "data": "0x000000000000000000000000000000000000000000000000015c2a75c2dd3b970000000000000000000000000000000000000000000000129c838750dc3e8000000000000000000000000000000000000000000000000000000000006615da9f"
    },
    "eventAbi":
    {
        "anonymous":false,
        "inputs":[
            {
                "indexed":true,
                "internalType":"address",
                "name":"user",
                "type":"address"
            },
            {
                "indexed":true,
                "internalType":"uint256",
                "name":"tokensBought",
                "type":"uint256"
            },
            {
                "indexed":true,
                "internalType":"address",
                "name":"purchaseToken",
                "type":"address"
            },
            {
                "indexed":false,
                "internalType":"uint256",
                "name":"amountPaid",
                "type":"uint256"
            },
            {
                "indexed":false,
                "internalType":"uint256",
                "name":"usdEq",
                "type":"uint256"
            },
            {
                "indexed":false,
                "internalType":"uint256",
                "name":"timestamp",
                "type":"uint256"
            }
        ],
        "name":"TokensBoughtAndStaked",
        "type":"event"
    }
}
```

Response Body:
```
{
    "logs": {
        "user": "0x97d2091959d48e466fc485d0f6ad30ac0078b01d",
        "tokensBought": "1183860",
        "purchaseToken": "0x0000000000000000000000000000000000000000",
        "amountPaid": "97999977164127127",
        "usdEq": "343319400000000000000",
        "timestamp": "1712708255"
    }
}
```
