#!/usr/bin/env pwsh

# Setup script for Rizquna.id WordPress project
# Usage: .\scripts\setup.ps1

Write-Host "🚀 Rizquna.id - WordPress Setup" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan

# Check if .env file exists
if (-not (Test-Path ".env")) {
    Write-Host "📋 Creating .env file from .env.example..." -ForegroundColor Yellow
    Copy-Item ".env.example" ".env"
    Write-Host "✅ .env file created. Please update database credentials if needed." -ForegroundColor Green
} else {
    Write-Host "ℹ️  .env file already exists" -ForegroundColor Cyan
}

# Create required directories
Write-Host "📁 Creating required directories..." -ForegroundColor Yellow
@("data/db", "data/uploads", "logs") | ForEach-Object {
    if (-not (Test-Path $_)) {
        New-Item -ItemType Directory -Path $_ -Force | Out-Null
        Write-Host "✅ Created $_" -ForegroundColor Green
    }
}

# Check Docker
Write-Host "🐳 Checking Docker..." -ForegroundColor Yellow
try {
    $dockerVersion = docker --version
    Write-Host "✅ Docker found: $dockerVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Docker not found. Please install Docker first." -ForegroundColor Red
    exit 1
}

# Build and start containers
Write-Host "🔨 Building Docker images..." -ForegroundColor Yellow
docker-compose build

Write-Host "▶️  Starting containers..." -ForegroundColor Yellow
docker-compose up -d

# Wait for services to be ready
Write-Host "⏳ Waiting for services to start..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

# Check if containers are running
$dbRunning = docker ps | Select-String "rizquna_db"
$appRunning = docker ps | Select-String "rizquna_app"

if ($dbRunning -and $appRunning) {
    Write-Host "✅ All containers running!" -ForegroundColor Green
} else {
    Write-Host "⚠️  Some containers may not be running yet" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "🎉 Setup Complete!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Cyan
Write-Host "WordPress URL: http://localhost:8088" -ForegroundColor Cyan
Write-Host "Database Host: localhost:33068" -ForegroundColor Cyan
Write-Host "Database Name: u9443309_wp827" -ForegroundColor Cyan
Write-Host "Database User: u9443309_wp827" -ForegroundColor Cyan
Write-Host ""
Write-Host "Useful commands:" -ForegroundColor Yellow
Write-Host "  docker-compose logs -f          # View logs" -ForegroundColor White
Write-Host "  docker-compose ps               # Check status" -ForegroundColor White
Write-Host "  docker-compose down             # Stop containers" -ForegroundColor White
