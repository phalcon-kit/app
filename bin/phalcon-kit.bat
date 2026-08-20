@echo off
rem ==============================================
rem ==  Phalcon Kit windows command line tool   ==
rem ==============================================
@setlocal
if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe
"%PHP_COMMAND%" "%~dp0phalcon-kit" %*
@endlocal
