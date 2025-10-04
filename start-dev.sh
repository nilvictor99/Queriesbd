#!/bin/bash
# filepath: /home/dev/Sites/inventory/start-dev.sh
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

# Execute npm install inside the container
docker exec $CONTAINER_ID npm i

# Run npm run dev interactively inside the container (this will attach the terminal)
docker exec -it $CONTAINER_ID npm run dev