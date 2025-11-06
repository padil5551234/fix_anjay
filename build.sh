#!/bin/bash
set -e

echo "Installing npm dependencies..."
npm install

echo "Building assets with Vite..."
npm run vercel-build

echo "Build completed successfully!"