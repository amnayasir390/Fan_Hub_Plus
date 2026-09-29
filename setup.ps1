# Fan Hub Plus — Setup Script
# Run this from the Fan_Hub_Plus directory in PowerShell as:
#   .\setup.ps1

Write-Host "=== Fan Hub Plus Setup ===" -ForegroundColor Magenta

# 1. Install PHP dependencies
Write-Host "`n[1/5] Installing Composer dependencies..." -ForegroundColor Cyan
composer install --no-interaction

# 2. Install Node dependencies
Write-Host "`n[2/5] Installing NPM dependencies..." -ForegroundColor Cyan
npm install

# 3. Run migrations and seed
Write-Host "`n[3/5] Running migrations and seeding database..." -ForegroundColor Cyan
C:\xampp\php\php.exe artisan migrate:fresh --seed --force

# 4. Create storage symlink
Write-Host "`n[4/5] Creating storage symlink..." -ForegroundColor Cyan
C:\xampp\php\php.exe artisan storage:link

# 5. Build frontend assets
Write-Host "`n[5/5] Building frontend assets..." -ForegroundColor Cyan
npm run build

Write-Host "`n=== Setup Complete! ===" -ForegroundColor Green
Write-Host "Start the dev server with:" -ForegroundColor Yellow
Write-Host "  C:\xampp\php\php.exe artisan serve" -ForegroundColor White
Write-Host "`nAdmin login:" -ForegroundColor Yellow
Write-Host "  Email:    admin@fanhubplus.com" -ForegroundColor White
Write-Host "  Password: password" -ForegroundColor White
Write-Host "`nFan login:" -ForegroundColor Yellow
Write-Host "  Email:    fan@fanhubplus.com" -ForegroundColor White
Write-Host "  Password: password" -ForegroundColor White
