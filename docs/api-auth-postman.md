# API Auth (Postman) - Stunting Detection Backend

Dokumen ini untuk testing endpoint auth pada backend Laravel:

- Base URL lokal: `http://localhost:8000`
- Prefix API: `/api/v1`

## 1) Register

- **Method:** `POST`
- **URL:** `/api/v1/auth/register`
- **Header:**

```http
Accept: application/json
Content-Type: application/json
```

- **Body (JSON):**

```json
{
  "full_name": "Anas Khalif",
  "phone_number": "081234567890",
  "address": "Jl. Mawar No. 1, Yogyakarta",
  "email": "anas@example.com",
  "password": "password123",
  "confirm_password": "password123"
}
```

### Catatan

- Field wajib: `full_name`, `phone_number`, `address`, `email`, `password`, `confirm_password`.
- User baru otomatis mendapat role default: `user` (Orang Tua).

### Contoh response sukses (201)

```json
{
  "message": "Registrasi berhasil.",
  "data": {
    "user": {
      "uid": "d8fdaf7b-16f8-4dd5-9238-2291a95b6cf6",
      "name": "Anas Khalif",
      "email": "anas@example.com",
      "phone_number": "081234567890",
      "address": "Jl. Mawar No. 1, Yogyakarta",
      "role": "user",
      "email_verified_at": null,
      "created_at": "2026-04-03T08:00:00.000000Z",
      "updated_at": "2026-04-03T08:00:00.000000Z"
    }
  }
}
```

## 2) Login

- **Method:** `POST`
- **URL:** `/api/v1/auth/login`
- **Header:**

```http
Accept: application/json
Content-Type: application/json
```

- **Body (JSON):**

```json
{
  "email": "anas@example.com",
  "password": "password123"
}
```

### Contoh response sukses (200)

```json
{
  "message": "Login berhasil.",
  "data": {
    "token": "1|XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
    "user": {
      "uid": "d8fdaf7b-16f8-4dd5-9238-2291a95b6cf6",
      "name": "Anas Khalif",
      "email": "anas@example.com",
      "phone_number": "081234567890",
      "address": "Jl. Mawar No. 1, Yogyakarta",
      "role": "user",
      "email_verified_at": null,
      "created_at": "2026-04-03T08:00:00.000000Z",
      "updated_at": "2026-04-03T08:00:00.000000Z"
    },
    "expires_at": null
  }
}
```

## 3) Profile (opsional untuk verifikasi login)

- **Method:** `GET`
- **URL:** `/api/v1/auth/profile`
- **Header:**

```http
Authorization: Bearer <token_dari_login>
Accept: application/json
```

## 4) Logout (opsional)

- **Method:** `POST`
- **URL:** `/api/v1/auth/logout`
- **Header:**

```http
Authorization: Bearer <token_dari_login>
Accept: application/json
```

## Postman setup singkat

1. Buat collection: `Stunting Detection Auth API`.
2. Tambah variable collection `base_url = http://localhost:8000`.
3. Gunakan URL request: `{{base_url}}/api/v1/auth/register` dan `{{base_url}}/api/v1/auth/login`.
4. Untuk endpoint protected, set tab Authorization -> `Bearer Token` dengan token dari login.
