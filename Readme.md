# API

## The Basics
The URL: `localhost/api/v1/endpoint-name/vars`

Requires to Header Keys to be set:
* `apiKey`
* `token`

Their values can be random as they are not checked at the moment.


##List of Endpoints:

| Name | Type | Params | Behavior |
| --- | --- | ---| --- |
| `orders` | `GET` | none | |
| `order` | `GET` | Order ID | |
| `alternatives` | `GET` | Endpoint ID| |
| `address` | `GET` | none | Returns all addresses |
| `address` | `GET` | `id` | Get the address with id = `id` |
| `address` | `DELETE` | `id` | Deletes the address with id = `id` |
| `address` | `POST` | none | Expects JSON. Creates address. |


## Endpoint Details

### orders
Returns the following for each order (Limited to 30)
```json
"id": 3456, //order id (int)
"weight": 500,
"width": 0,
"height": 0,
"depth": 0,
"route_id": 1,
"dropoff_not_before": "21:00:00",
"dropoff_not_after": "21:00:00",
"pickup_not_before": "06:00:00",
"pickup_not_after": "20:00:00",
"created_by": 1,
"created_at": "2016-12-20 18:00:00",
"complete": 0,
"pickup_endpoint_id": 2,
"dropoff_endpoint_id": 1,
"pickup_name": "BCS",
"address_id": 1,
"endpoint_type_id": 1,
"pickup_type": "Office",
"pickup_street": "Charlottenstr. 4",
"pickup_adendum": null,
"pickup_zip": "12354",
"pickup_city": "Berlin",
"pickup_country": "Germany",
"dropoff_name": "BTD",
"dropoff_type": "Office",
"dropoff_street": "Tamara-Danz Str. 1",
"dropoff_adendum": null,
"dropoff_zip": "12345",
"dropoff_city": "Berlin",
"dropoff_country": "Germany"
```

### address
#### POST
The following parameters are required / possible:

| param | type | required |
| --- | --- | ---- |
| id | int | no |
| street | string | yes |
| adendum | string | no |
| zip | int | yes |
| city | string | yes |
| country | string | no |
