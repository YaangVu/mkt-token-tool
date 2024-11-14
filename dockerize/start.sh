#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
queue=${QUEUE:-default}

chmod -R 777 storage

echo "Migrate database"
php artisan migrate --force

# Re-optimize Laravel App
php artisan optimize

if [ "$role" = "app" ]; then
    echo "App is running..."
    php artisan storage:link
    php artisan filament:optimize
    php artisan serve --host=0.0.0.0

elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    # Run the rabbitmq queues. See more at: https://github.com/vyuldashev/laravel-queue-rabbitmq
    php artisan queue:work--queue="${queue}" --verbose --tries=3 --timeout=90

elif [ "$role" = "scheduler" ]; then
    echo "Scheduler is running..."
    while true
    do
      php artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
