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
