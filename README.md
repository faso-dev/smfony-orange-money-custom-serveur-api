# Setup a CUSTOM ORANGE MONEY BURKINA SERVER REST API for testing or production


## Configuration

In the `.env` file, set theses variables : 
```
ORANGE_MONEY_USERNAME=your orange money api username
ORANGE_MONEY_PASSWORD=your orange money api password
ORANGE_MONEY_MERCHANT_ID=your orange money merchant id
```

## Start serveur

```shell
symfony server:start && symfony server:log
```

## End points

`http(s)://server-adress:port/api/v1` to show how to use payment api

## JS Users
```json
{
    "message": "My custom serveur payment api",
    "version": "v1",
    "documentation": {
        "version": "v1",
        "make_payment_request": {
            "with_fetch_or_axios": {
                "url": "http-sheme://server-adress:port/api/v1/pay",
                "method": "POST",
                "headers": {
                    "Content-type": "application/json"
                },
                "body_or_data": {
                    "client_number": "00000000",
                    "payment_amount": "100",
                    "otp": "123456"
                }
           }
        }
    }
}
```
