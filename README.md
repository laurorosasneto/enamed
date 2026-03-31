# local_boletimenamed

Plugin local para Moodle 4.5+.

## Fluxo de trabalho

1. Desenvolver localmente nesta pasta.
2. Versionar com Git.
3. Publicar no servidor via SSH com script de deploy.

## SSH e deploy

- Host: `108.181.92.77`
- Porta: `22`
- Usuario: `uov3of3u`
- Raiz do Moodle no servidor: `/home/uov3of3u/public_html/enamed`
- Destino do plugin: `/home/uov3of3u/public_html/enamed/local/boletimenamed`
- A chave privada local fica fora do versionamento em `.codex-ssh/`.
- O script [`scripts/deploy.ps1`](d:/FAMETRO/ENAMED/RECURSOS/moodle/local_boletimenamed/scripts/deploy.ps1) envia os arquivos para o servidor.

## Pendencias

- Adicionar a chave publica gerada localmente em `authorized_keys` do servidor.
- Definir o remoto Git principal do projeto.

## Versionamento

Comandos iniciais:

```powershell
git add .
git commit -m "chore: bootstrap do plugin local_boletimenamed"
```

Quando o remoto Git existir:

```powershell
git remote add origin <url-do-repositorio>
git push -u origin main
```

Deploy manual depois de autorizar a chave SSH:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\deploy.ps1
```
