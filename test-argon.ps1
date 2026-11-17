# Test script to verify connection to Gemini 4 Argon via 9Router
$ErrorActionPreference = "Stop"

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  Testing Connection to 9Router & Argon   " -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan

$endpoint = "http://localhost:20128/v1/chat/completions"
$apiKey = "sk-8235bd08148240fe-0s8bbc-70b2ef53"
$model = "ag/gemini-4-argon-medium"

$headers = @{
    "Authorization" = "Bearer $apiKey"
    "Content-Type"  = "application/json"
}

$body = @{
    model = $model
    messages = @(
        @{ role = "user"; content = "Katakan 'Halo, Gemini 4 Argon siap digunakan untuk ngoding!' dalam 1 kalimat singkat." }
    )
    max_tokens = 60
} | ConvertTo-Json

try {
    $sw = [System.Diagnostics.Stopwatch]::StartNew()
    $response = Invoke-RestMethod -Uri $endpoint -Method Post -Headers $headers -Body $body -TimeoutSec 15
    $sw.Stop()

    $content = ""
    if ($response -is [string]) {
        # Streaming response (SSE chunks)
        $lines = $response -split "`n" | Where-Object { $_ -match '^data:\s*\{' }
        foreach ($line in $lines) {
            $jsonStr = $line -replace '^data:\s*', ''
            try {
                $obj = $jsonStr | ConvertFrom-Json
                if ($obj.choices -and $obj.choices[0].delta.content) {
                    $content += $obj.choices[0].delta.content
                }
            } catch {}
        }
    } elseif ($response.choices) {
        $content = $response.choices[0].message.content
        if (-not $content) {
            $content = $response.choices[0].delta.content
        }
    }

    Write-Host "[SUCCESS] Terhubung ke 9Router!" -ForegroundColor Green
    Write-Host "Model     : $model" -ForegroundColor Yellow
    Write-Host "Waktu     : $($sw.ElapsedMilliseconds) ms" -ForegroundColor Yellow
    Write-Host "Respon    : $content" -ForegroundColor White
} catch {
    Write-Host "[ERROR] Gagal terhubung ke 9Router: $_" -ForegroundColor Red
}
Write-Host "==========================================" -ForegroundColor Cyan
