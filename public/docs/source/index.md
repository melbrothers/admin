---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Forgot Password

Send password reset email
<!-- START_59d65f2e6393ef7326e8a5e6ef4b53a0 -->
## Send a reset link to the given user.

> Example request:

```bash
curl -X POST "http://localhost/password/email"     -d "email"="coafydwj5hfiOhQr" 
```

```javascript
const url = new URL("http://localhost/password/email");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "coafydwj5hfiOhQr",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /password/email`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User'email

<!-- END_59d65f2e6393ef7326e8a5e6ef4b53a0 -->

#Login

Log in user
<!-- START_dd217657c6d30db33bd0158a8815a014 -->
## Handle an authentication attempt.

> Example request:

```bash
curl -X POST "http://localhost/login"     -d "email"="EjbgEkkzRkdNqwuL" \
    -d "password"="1MLsZKrNHfWoEGKV" 
```

```javascript
const url = new URL("http://localhost/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "EjbgEkkzRkdNqwuL",
    "password": "1MLsZKrNHfWoEGKV",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User'email
    password | string |  required  | User's password

<!-- END_dd217657c6d30db33bd0158a8815a014 -->

#Register

Register a user
<!-- START_669c21a0ec50102c5d7a38fdaec7d34e -->
## /register
> Example request:

```bash
curl -X POST "http://localhost/register"     -d "email"="eNFXgaOZrsPthCtc" \
    -d "password"="nhbXdutzPUqm7H5v" \
    -d "name"="VVBtvBIsPD2bJMap" \
    -d "password_confirmation"="JjCO2XdING2wkRfg" 
```

```javascript
const url = new URL("http://localhost/register");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "eNFXgaOZrsPthCtc",
    "password": "nhbXdutzPUqm7H5v",
    "name": "VVBtvBIsPD2bJMap",
    "password_confirmation": "JjCO2XdING2wkRfg",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User'email
    password | string |  required  | User's password
    name | string |  required  | User's name
    password_confirmation | string |  required  | User's password confirmation

<!-- END_669c21a0ec50102c5d7a38fdaec7d34e -->

#Reset Password

Rest user password
<!-- START_369c8bbb0872d3af653c4bce0f8bbec1 -->
## Reset the given user&#039;s password.

> Example request:

```bash
curl -X POST "http://localhost/password/reset"     -d "token"="g4Ac5STIkZ9spBp0" \
    -d "email"="0oGeL46i3NOdUcDv" \
    -d "password"="pHyf1OPJL9hPay3b" \
    -d "confirm_password"="g2Y6yCsm5K0xIVQQ" 
```

```javascript
const url = new URL("http://localhost/password/reset");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "token": "g4Ac5STIkZ9spBp0",
    "email": "0oGeL46i3NOdUcDv",
    "password": "pHyf1OPJL9hPay3b",
    "confirm_password": "g2Y6yCsm5K0xIVQQ",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /password/reset`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | string |  required  | Token for resetting email
    email | string |  required  | User's email
    password | string |  required  | User's password
    confirm_password | string |  required  | User's confirm password

<!-- END_369c8bbb0872d3af653c4bce0f8bbec1 -->

#Socaial Login

Social login
<!-- START_578e010f0a2b2221c9ba8c7ff1afa913 -->
## Redirect the user to the Facebook authentication page.

> Example request:

```bash
curl -X GET -G "http://localhost/social/{provider}/login" 
```

```javascript
const url = new URL("http://localhost/social/{provider}/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /social/{provider}/login`


<!-- END_578e010f0a2b2221c9ba8c7ff1afa913 -->

<!-- START_d0c62929c88f5b7a60418e3abf9b44d3 -->
## Obtain the user information from Facebook.

> Example request:

```bash
curl -X GET -G "http://localhost/social/{provider}/callback" 
```

```javascript
const url = new URL("http://localhost/social/{provider}/callback");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /social/{provider}/callback`


<!-- END_d0c62929c88f5b7a60418e3abf9b44d3 -->

#User Management

APIs for managing users
<!-- START_9debb5425f1bd6f66559a3377002bc79 -->
## /v1/users
> Example request:

```bash
curl -X POST "http://localhost/v1/users" 
```

```javascript
const url = new URL("http://localhost/v1/users");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/users`


<!-- END_9debb5425f1bd6f66559a3377002bc79 -->

<!-- START_adbf91a8796b1c79b05bd58538ad19c0 -->
## /v1/users/{id}
> Example request:

```bash
curl -X GET -G "http://localhost/v1/users/{id}" 
```

```javascript
const url = new URL("http://localhost/v1/users/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "id": 4,
    "name": "Jessica Jones",
    "roles": [
        "admin"
    ]
}
```
> Example response (404):

```json
{}
```

### HTTP Request
`GET /v1/users/{id}`


<!-- END_adbf91a8796b1c79b05bd58538ad19c0 -->

<!-- START_2d312ab8c43ddaa925be26990ce782bf -->
## /v1/users
> Example request:

```bash
curl -X GET -G "http://localhost/v1/users" 
```

```javascript
const url = new URL("http://localhost/v1/users");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/users`


<!-- END_2d312ab8c43ddaa925be26990ce782bf -->

<!-- START_56df20631515b8dd1dfbd940019f0a0f -->
## /v1/users/{id}
> Example request:

```bash
curl -X PUT "http://localhost/v1/users/{id}" 
```

```javascript
const url = new URL("http://localhost/v1/users/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT /v1/users/{id}`


<!-- END_56df20631515b8dd1dfbd940019f0a0f -->

<!-- START_81ae75d1d6dbdd3f1f1cbdb7a225d219 -->
## /v1/users/{id}
> Example request:

```bash
curl -X DELETE "http://localhost/v1/users/{id}" 
```

```javascript
const url = new URL("http://localhost/v1/users/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /v1/users/{id}`


<!-- END_81ae75d1d6dbdd3f1f1cbdb7a225d219 -->

#Verify Email

Verify user's email
<!-- START_a7c5f10924c9b7d0b4f6e555b2a2e7ea -->
## Mark the authenticated user&#039;s email address as verified.

> Example request:

```bash
curl -X GET -G "http://localhost/email/verify/{id}" 
```

```javascript
const url = new URL("http://localhost/email/verify/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /email/verify/{id}`


<!-- END_a7c5f10924c9b7d0b4f6e555b2a2e7ea -->

<!-- START_662360c4f014a2da93de7efc2d65e089 -->
## Resend the email verification notification.

> Example request:

```bash
curl -X GET -G "http://localhost/email/resend" 
```

```javascript
const url = new URL("http://localhost/email/resend");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /email/resend`


<!-- END_662360c4f014a2da93de7efc2d65e089 -->

#general
<!-- START_9a4925a3d6314fb381b0093b9d14a6ef -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl -X POST "http://localhost/oauth/token" 
```

```javascript
const url = new URL("http://localhost/oauth/token");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/token`


<!-- END_9a4925a3d6314fb381b0093b9d14a6ef -->

<!-- START_d54562e90bf04151dc7d95837e558b77 -->
## Get all of the authorized tokens for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/tokens`


<!-- END_d54562e90bf04151dc7d95837e558b77 -->

<!-- START_abfd09e36c4951d11ca1c7d8d30d5c4d -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/tokens/{token_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/tokens/{token_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /oauth/tokens/{token_id}`


<!-- END_abfd09e36c4951d11ca1c7d8d30d5c4d -->

<!-- START_22ac64c785e062e9fb762f3d39a3618a -->
## Get a fresh transient token cookie for the authenticated user.

> Example request:

```bash
curl -X POST "http://localhost/oauth/token/refresh" 
```

```javascript
const url = new URL("http://localhost/oauth/token/refresh");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/token/refresh`


<!-- END_22ac64c785e062e9fb762f3d39a3618a -->

<!-- START_e68f5945e5b3115f409c97d70ce109c1 -->
## Get all of the clients for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/clients" 
```

```javascript
const url = new URL("http://localhost/oauth/clients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/clients`


<!-- END_e68f5945e5b3115f409c97d70ce109c1 -->

<!-- START_cc62a849d5b8a0f6c7fe5bf8f37dca37 -->
## Store a new client.

> Example request:

```bash
curl -X POST "http://localhost/oauth/clients" 
```

```javascript
const url = new URL("http://localhost/oauth/clients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/clients`


<!-- END_cc62a849d5b8a0f6c7fe5bf8f37dca37 -->

<!-- START_68765e4a9497ffd5ca366e85432e1b8d -->
## Update the given client.

> Example request:

```bash
curl -X PUT "http://localhost/oauth/clients/{client_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/clients/{client_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT /oauth/clients/{client_id}`


<!-- END_68765e4a9497ffd5ca366e85432e1b8d -->

<!-- START_d37a14b237044eea20249e407316f2b5 -->
## Delete the given client.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/clients/{client_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/clients/{client_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /oauth/clients/{client_id}`


<!-- END_d37a14b237044eea20249e407316f2b5 -->

<!-- START_3999012556e9b9cfd7380bbd3e5f4b3f -->
## Get all of the available scopes for the application.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/scopes" 
```

```javascript
const url = new URL("http://localhost/oauth/scopes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/scopes`


<!-- END_3999012556e9b9cfd7380bbd3e5f4b3f -->

<!-- START_f424300762915d20d5a642e271ac4364 -->
## Get all of the personal access tokens for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/personal-access-tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/personal-access-tokens`


<!-- END_f424300762915d20d5a642e271ac4364 -->

<!-- START_fd958d9a4d7d5e2efa1a8de529cdccf4 -->
## Create a new personal access token for the user.

> Example request:

```bash
curl -X POST "http://localhost/oauth/personal-access-tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/personal-access-tokens`


<!-- END_fd958d9a4d7d5e2efa1a8de529cdccf4 -->

<!-- START_5df9f91254ca5b0217f0cd72e341e39b -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/personal-access-tokens/{token_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens/{token_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /oauth/personal-access-tokens/{token_id}`


<!-- END_5df9f91254ca5b0217f0cd72e341e39b -->


