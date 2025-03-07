#!/bin/bash

# Hapus folder /tmp/caddy jika ada
rm -rf /tmp/caddy

# Pindah ke direktori proyek
cd /www/wwwroot/dap.dpplast.com/ddpApps || exit

# Jalankan Laravel Octane dengan FrankenPHP
PHP_INI_SCAN_DIR=/etc/php-custom php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000
