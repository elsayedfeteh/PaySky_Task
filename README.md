# E-Commerce Platform API

This is a simple e-commerce platform API built with Laravel. It allows users to manage orders and simulate payment processes.

## Table of Contents
1. [Setup Instructions](#setup-instructions)
2. [API Documentation](#api-documentation)
3. [Database Schema](#database-schema)

## Setup Instructions

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL
- Laravel CLI

### Installation
1. Clone the repository:
   ```bash
   git clone git@github.com:elsayedfeteh/PaySky_Task.git
   cd ecommerce-platform
2. Install dependencies:
   ```bash
   composer install
3. Set up the .env file:
   ```bash
   cp .env.example .env
4. Generate the application key:
   ```bash
   php artisan key:generate
5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
6. Start the development server:
   ```bash
   php artisan serve
## API Documentation

### Base URL
[URL](http://localhost:8000/api/v1): http://localhost:8000/api/v1

### Postman Collection
https://documenter.getpostman.com/view/18700911/2sAYQamrHe

### Endpoints

#### Create an Order
- **URL**: `/orders`
- **Method**: `POST`
- **Request Body**:
  ```json
  {
    "products": [
      {
        "product_id": 1,
        "quantity": 2
      }
    ]
  }

#### Get Orders
- **URL**: `/orders`
- **Method**: `GET`

## Database Schema

### Tables

#### `products`
- `id` (Primary Key)
- `name` (String)
- `price` (Float)
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

#### `orders`
- `id` (Primary Key)
- `user_id` (Foreign Key to `users`)
- `tax_rate` (Float, e.g., 0.10 for 10%)
- `total_products_price` (Float)
- `total_price` (Float)
- `status` (Enum: [`pending`, `processing`, `completed`, `failed`])
- `payment_status` (Enum: [`pending`, `successful`, `failed`])
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

#### `order_products` (Pivot Table)
- `id` (Primary Key)
- `order_id` (Foreign Key to `orders`)
- `product_id` (Foreign Key to `products`)
- `quantity` (Integer)
- `price` (Float)
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

### Relationships
- An order can have many products.
- A product can belong to many orders.