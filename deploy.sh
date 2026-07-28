#!/bin/bash
set -e

echo "Starting Production Deployment for Pembayaran SPP..."

# 1. Pull the latest code from master/main
echo "Pulling latest changes from repository..."
git pull origin main

# 2. Install composer dependencies (Optimized for Production)
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Run database migrations
echo "Running Database Migrations..."
php artisan migrate --force

# 4. Clear and rebuild application cache
echo "Clearing and caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Restart queue worker (if applicable)
echo "Restarting Queue Workers..."
php artisan queue:restart || true

echo "Production Deployment Successfully Completed!"
