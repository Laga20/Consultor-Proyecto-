@echo off
title Publicador Consultor2.0
cd /d "%~dp0"
echo ============================================
echo   PUBLICADOR Consultor2.0 - Git push
echo ============================================
echo.
echo Cambios detectados:
git status --short
echo.
set /p MSG="Comentario del cambio (luego Enter): "
if "%MSG%"=="" set MSG=Actualizacion del proyecto
git add .
git commit -m "%MSG%"
git push
echo.
echo ============================================
git log --oneline -3
echo ============================================
echo Listo! Revisa https://github.com/Laga20/Consultor-Proyecto-
pause
