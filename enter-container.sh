#!/bin/bash
# filepath: /home/dev/Sites/inventory/enter-container.sh

# Start Docker Compose in detached mode
docker compose up -d

# Wait for containers to be ready
sleep 10

# Get the container ID for the Laravel app (inventory-laravel.test-1)
CONTAINER_ID=$(basename $(pwd) | tr '[:upper:]' '[:lower:]' | xargs -I {} docker ps --filter "name={}-laravel.test-1" --format "{{.ID}}")

if [ -z "$CONTAINER_ID" ]; then
    echo "Laravel container not found. Please check if Docker Compose started correctly."
    exit 1
fi

# Enter the container interactively
docker exec -it $CONTAINER_ID bash