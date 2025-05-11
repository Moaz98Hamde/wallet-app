# Wallet App

A Laravel-based wallet system that allows users to credit and debit funds from their wallet, with authentication and validation.

## Requirements

- PHP 8.1+
- Composer
- MySQL (or compatible database)
- Laravel Sanctum for API authentication

## Setup Instructions

1. **Clone the repository**
```bash
git clone <repository-url>
cd <project-directory>
```

2. **Install dependencies**
```bash
composer install
```

3. **Set up environment**
```bash
cp .env.example .env
```

4. **Generate application key**
```bash
php artisan key:generate
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Serve the application**
```bash
php artisan serve
```

## Authentication

This application uses **Laravel Sanctum** for API token authentication. Make sure your frontend includes the token in requests as a bearer token.

## API Endpoints Documentation

All wallet-related endpoints are protected by Sanctum authentication middleware.

### `GET /api/wallet`

**Description:** Retrieve the current authenticated user's wallet balance and transaction history.

**Headers:**
```
Authorization: Bearer <token>
```

**Response Example:**
```json
{
  "balance": 1200.50,
  "transactions": [
    {
      "type": "credit",
      "amount": 500,
      "created_at": "2025-05-11T08:15:30Z"
    },
    ...
  ]
}
```

---

### `POST /api/wallet/credit`

**Description:** Credit a specific amount to the authenticated user's wallet.

**Headers:**
```
Authorization: Bearer <token>
Content-Type: application/json
```

**Request Body:**
```json
{
  "amount": 100
}
```

**Response Example:**
```json
{
  "message": "Wallet credited successfully",
  "new_balance": 1300.50
}
```

---

### `POST /api/wallet/debit`

**Description:** Debit a specific amount from the authenticated user's wallet. Will return an error if funds are insufficient.

**Headers:**
```
Authorization: Bearer <token>
Content-Type: application/json
```

**Request Body:**
```json
{
  "amount": 150
}
```

**Response Example (Success):**
```json
{
  "message": "Wallet debited successfully",
  "new_balance": 1150.50
}
```

**Response Example (Failure):**
```json
{
  "message": "Insufficient funds"
}
```

---

## Possible Improvements

1. Add transaction filtering (date range, type)
2. Introduce soft deletes or reversible transactions
3. Add support for multiple wallets per user (supported)
4. Add webhooks for external transaction tracking
5. Improve validation and error messages
6. Transfer balance between wallets
