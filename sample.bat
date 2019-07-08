@echo off
echo.%cmdcmdline% | find /I "%~0" >nul
START /MIN CMD.EXE /C C:\XWeb\XWeb.exe /script:"C:\XWeb\My Scripts\init.php" /script_args:"%*"
