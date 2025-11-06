# Vercel Build Error Fix

## Problem
The Vercel deployment was failing with the error:
```
RollupError: Could not resolve entry module "index.html"
```

This occurred because the `vercel.json` configuration had conflicting build setups - it was trying to use Vite as a static site builder, which expects an `index.html` file. However, this is a Laravel application that uses Vite only for asset compilation, not as the main build tool.

## Solution Applied

### 1. Updated `vite.config.js`
- Added explicit `manifest: true` to ensure Vite generates the manifest file that Laravel needs
- Kept the Laravel Vite plugin configuration intact

### 2. Updated `vercel.json`
- **Removed** the conflicting static build configuration (`@vercel/static-build`)
- **Kept** only the PHP build configuration (`vercel-php@0.7.3`)
- **Added** all necessary build configuration files to `includeFiles`:
  - `vite.config.js`
  - `postcss.config.js`
  - `tailwind.config.js`
  - `package.json`
  - `package-lock.json`
  - `build.sh`
  - `resources/css/**`
  - `resources/js/**`
- **Added** `buildCommand: "bash build.sh"` to run asset compilation before PHP deployment

### 3. Created `build.sh`
A build script that:
1. Installs npm dependencies
2. Runs Vite build to compile assets
3. Outputs success message

## How It Works Now

1. Vercel clones the repository
2. The PHP builder (`vercel-php@0.7.3`) is configured to run `build.sh` before deployment
3. `build.sh` installs npm packages and compiles assets using Vite
4. The compiled assets are placed in `public/build/`
5. The PHP application is then deployed with all assets included

## Testing the Fix

To test if this fix works:

1. Commit and push these changes to your repository:
   ```bash
   git add vite.config.js vercel.json build.sh VERCEL_BUILD_FIX.md
   git commit -m "Fix Vercel build error - resolve index.html issue"
   git push origin main
   ```

2. Vercel will automatically trigger a new deployment

3. Monitor the build logs in your Vercel dashboard

## Expected Build Output

You should see:
```
Installing npm dependencies...
npm install
...
Building assets with Vite...
npm run vercel-build
vite v4.2.1 building for production...
✓ built in [time]
Build completed successfully!
```

## Alternative Solution (If Above Doesn't Work)

If the `buildCommand` property is not supported by `vercel-php@0.7.3`, you can:

### Option 1: Pre-build Assets Locally
Build assets locally and commit them to the repository:
```bash
npm install
npm run build
git add public/build/
git commit -m "Add pre-built assets"
git push
```

Then remove the `buildCommand` from `vercel.json`.

### Option 2: Use Vercel Build Hook
Add a `vercel-build` script in the root `package.json` that includes both npm install and build, and ensure Vercel runs this before the PHP build.

## Files Modified
- `tryout-master/vite.config.js` - Updated build configuration
- `tryout-master/vercel.json` - Removed conflicting build, added buildCommand
- `tryout-master/build.sh` - Created new build script (NEW)
- `tryout-master/VERCEL_BUILD_FIX.md` - This documentation (NEW)

## Important Notes

1. The `public/build/` directory will be generated during the Vercel build process
2. Make sure `public/build/` is NOT in `.gitignore` if you choose Option 1
3. The Laravel application will use the Vite manifest to load the correct asset files
4. All routes are properly configured to serve static assets from `/build/` path