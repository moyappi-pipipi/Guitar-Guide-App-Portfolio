FROM mcr.microsoft.com/devcontainers/php:1-8.4-bookworm

# Base image の壊れた yarn apt リポジトリを除去してから Node / MySQL client を入れる
RUN rm -f /etc/apt/sources.list.d/yarn.list \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs default-mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Laravel 用 MySQL 拡張
RUN docker-php-ext-install pdo_mysql mysqli

WORKDIR /workspace
