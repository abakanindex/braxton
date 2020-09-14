@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/yiisoft/yii2/yii
php "%BIN_TARGET%" %*
