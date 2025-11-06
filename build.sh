#!/bin/bash
set -e

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "Installing npm dependencies..."
npm install

echo "Building assets with Vite..."
npm run vercel-build

echo "Build completed successfully!"