param(
    [Parameter(Mandatory = $true)]
    [string]$RemotePath
)

$ErrorActionPreference = "Stop"

$projectRoot = Split-Path -Parent $PSScriptRoot
$sshDir = Join-Path $projectRoot ".codex-ssh"
$sshConfig = Join-Path $sshDir "config"
$knownHosts = Join-Path $sshDir "known_hosts"
$sourcePath = Join-Path $projectRoot "*"

if (-not (Test-Path $sshConfig)) {
    throw "Arquivo de configuracao SSH nao encontrado em $sshConfig."
}

if (-not (Test-Path $knownHosts)) {
    throw "Arquivo known_hosts nao encontrado em $knownHosts."
}

ssh -F $sshConfig moodle-prod "mkdir -p '$RemotePath'"
scp -F $sshConfig -r $sourcePath "moodle-prod:$RemotePath"

Write-Host "Deploy concluido para $RemotePath"
